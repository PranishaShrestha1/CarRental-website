<?php
session_start();
include('includes/config.php');
error_reporting(0);

// CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_msg'] = "Invalid form submission. Please try again.";
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if user is logged in
    if(!isset($_SESSION['login'])) {
        $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
        $_SESSION['error_msg'] = "Please login to book a vehicle";
        header("Location: login.php");
        exit();
    }

    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $pickup_location = $_POST['pickup_location']; // New field
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0;
    $vhid = intval($_GET['vhid']);
    $bookingno = mt_rand(100000000, 999999999);

    // Validate dates and new field
    $today = date('Y-m-d');
    if ($fromdate < $today || $todate < $today || $fromdate > $todate) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Invalid date selection. Please choose valid dates.';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    if (empty(trim($pickup_location))) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Please enter a pickup and drop location';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    // Check if files were uploaded
    if(empty($_FILES['national_id']['name']) || empty($_FILES['driving_license']['name'])) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Please upload both National ID/Passport and Driving License images';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    // Check if the same user has already booked this vehicle for overlapping dates
    $ret = "SELECT * FROM tblbooking
            WHERE
            (:fromdate BETWEEN FromDate AND ToDate OR
             :todate BETWEEN FromDate AND ToDate OR
             FromDate BETWEEN :fromdate AND :todate)
            AND VehicleId = :vhid
            AND userEmail = :useremail";

    $query = $dbh->prepare($ret);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'You have already booked this vehicle for the same dates';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    // Process file uploads
    $uploadDir = 'admin/uploads/documents/';
   
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // File validation
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $nationalIdTmp = $_FILES['national_id']['tmp_name'];
    $drivingLicenseTmp = $_FILES['driving_license']['tmp_name'];
   
    $nationalIdType = mime_content_type($nationalIdTmp);
    $drivingLicenseType = mime_content_type($drivingLicenseTmp);
   
    if (!in_array($nationalIdType, $allowedTypes) ||
        !in_array($drivingLicenseType, $allowedTypes) ||
        $_FILES['national_id']['size'] > $maxSize ||
        $_FILES['driving_license']['size'] > $maxSize) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Only JPG, PNG, or GIF images under 2MB are allowed';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    // Generate unique filenames
    $nationalIdName = uniqid() . '_' . basename($_FILES['national_id']['name']);
    $drivingLicenseName = uniqid() . '_' . basename($_FILES['driving_license']['name']);
    
    $nationalIdPath = $uploadDir . $nationalIdName;
    $drivingLicensePath = $uploadDir . $drivingLicenseName;

    // Move uploaded files
    if (!move_uploaded_file($_FILES['national_id']['tmp_name'], $nationalIdPath) ||
        !move_uploaded_file($_FILES['driving_license']['tmp_name'], $drivingLicensePath)) {
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Error uploading documents. Please try again.';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }

    // Insert booking
    $sql = "INSERT INTO tblbooking(BookingNumber, userEmail, VehicleId, FromDate, ToDate, PickupLocation, message, Status, NationalIdPath, DrivingLicensePath)
            VALUES(:bookingno, :useremail, :vhid, :fromdate, :todate, :pickupLocation, :message, :status, :nationalIdPath, :drivingLicensePath)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':pickupLocation', $pickup_location, PDO::PARAM_STR); // New binding
    $query->bindParam(':message', $message, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':nationalIdPath', $nationalIdPath, PDO::PARAM_STR);
    $query->bindParam(':drivingLicensePath', $drivingLicensePath, PDO::PARAM_STR);
    
    if($query->execute()) {
        $lastInsertId = $dbh->lastInsertId();
        
        $_SESSION['booking_success'] = "Booking successful. Your booking number is: $bookingno";
        
        // Clear form data
        if(isset($_SESSION['form_data'])) {
            unset($_SESSION['form_data']);
        }
        
        // Ensure session is written before redirect
        session_write_close();
        header("Location: my-booking.php");
        exit();
    } else {
        // Delete uploaded files if booking failed
        if(file_exists($nationalIdPath)) unlink($nationalIdPath);
        if(file_exists($drivingLicensePath)) unlink($drivingLicensePath);
        
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_msg'] = 'Something went wrong. Please try again';
        header("Location: vehical-details.php?vhid=$vhid");
        exit();
    }
}

// Check for existing bookings by this user for this vehicle
$existingBooking = false;
if(isset($_SESSION['login'])) {
    $useremail = $_SESSION['login'];
    $vhid = intval($_GET['vhid']);
    
    $ret = "SELECT * FROM tblbooking 
            WHERE userEmail = :useremail 
            AND VehicleId = :vhid
            AND (ToDate >= CURDATE())";
    $query = $dbh->prepare($ret);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':vhid', $vhid, PDO::PARAM_INT);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        $existingBooking = true;
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Car Rental | Vehicle Details</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!-- Custom Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!-- OWL Carousel slider -->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!-- slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!-- bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

<style>
    .similar_cars .grid_listing {
      display: flex;
      flex-direction: column;
    }

    .similar_cars .product-listing-m {
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 1px solid #eee;
      border-radius: 8px;
      padding: 10px;
      background-color: #f9f9f9;
    }

    .similar_cars .product-listing-img img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 6px;
    }

    .similar_cars .product-listing-content {
      margin-top: 15px;
    }
   
    .document-upload {
      margin-bottom: 15px;
    }
   
    .document-upload label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
   
    .document-upload input[type="file"] {
      display: block;
      width: 100%;
    }
   
    .file-requirements {
      font-size: 12px;
      color: #666;
      margin-top: 5px;
    }
    
    .alert-message {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    
    .alert-error {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
    
    .alert-warning {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc;
    }
    
    /* New alert styles */
    .alert {
        margin-top: 20px;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 4px;
    }
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
    .alert-dismissible .close {
        position: relative;
        top: -5px;
        right: -10px;
        color: inherit;
    }
</style>
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header -->

<!-- Display Messages -->
<div class="container">
    <?php if(isset($_SESSION['error_msg'])): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> <?php echo htmlentities($_SESSION['error_msg']); ?>
            <?php unset($_SESSION['error_msg']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> <?php echo htmlentities($_SESSION['success_msg']); ?>
            <?php unset($_SESSION['success_msg']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['warning_msg'])): ?>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Warning!</strong> <?php echo htmlentities($_SESSION['warning_msg']); ?>
            <?php unset($_SESSION['warning_msg']); ?>
        </div>
    <?php endif; ?>
</div>

<!--Listing-Image-Slider-->
<?php
$vhid=intval($_GET['vhid']);
$sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  
        FROM tblvehicles
        JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand
        WHERE tblvehicles.id=:vhid";
$query = $dbh->prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_INT);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0) {
    foreach($results as $result) {  
        $_SESSION['brndid'] = $result->bid;  
?>  
<section id="listing_img_slider">
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5!="") { ?>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->

<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>Rs.<?php echo htmlentities($result->PricePerDay);?> </p>Per Day
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->ModelYear);?></h5>
              <p>Reg.Year</p>
            </li>
            <li> <i class="fa fa-cogs" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->FuelType);?></h5>
              <p>Fuel Type</p>
            </li>
            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->SeatingCapacity);?></h5>
              <p>Seats</p>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview </a></li>
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessories</a></li>
            </ul>
           
            <!-- Tab panes -->
            <div class="tab-content">
              <!-- vehicle-overview -->
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                <p><?php echo htmlentities($result->VehiclesOverview);?></p>
              </div>
             
              <!-- Accessories -->
              <div role="tabpanel" class="tab-pane" id="accessories">
                <!--Accessories-->
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Accessories</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Air Conditioner</td>
                      <?php if($result->AirConditioner==1): ?>
                      <td><i class="fa fa-check" aria-hidden="true"></i></td>
                      <?php else: ?>
                      <td><i class="fa fa-close" aria-hidden="true"></i></td>
                      <?php endif; ?>
                    </tr>
                    <!-- Repeat for other accessories -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
<?php }} ?>
      </div>
     
      <!--Side-Bar-->
      <aside class="col-md-3">
        <div class="share_vehicle">
          <p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Now</h5>
          </div>
  
          <?php if($existingBooking): ?>
              <div class="alert alert-info">
                  You have already booked this vehicle.
              </div>
          <?php else: ?>
              <form method="post" enctype="multipart/form-data" onsubmit="return validateBookingForm()">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="form-group">
                  <label>From Date:</label>
                  <input type="date" name="fromdate" id="fromdate" placeholder="Date" class="form-control" required 
                        min="<?php echo date('Y-m-d'); ?>" 
                        value="<?php echo isset($_SESSION['form_data']['fromdate']) ? htmlentities($_SESSION['form_data']['fromdate']) : ''; ?>">
                </div>
        
                <div class="form-group">
                  <label>To Date:</label>
                  <input type="date" name="todate" id="todate" placeholder="Date" class="form-control" required 
                        min="<?php echo date('Y-m-d'); ?>" 
                        value="<?php echo isset($_SESSION['form_data']['todate']) ? htmlentities($_SESSION['form_data']['todate']) : ''; ?>">
                </div>
                
                <div class="form-group">
                  <label>Pick up & Drop location:</label>
                  <input type="text" name="pickup_location" id="pickup_location" class="form-control" required 
                        placeholder="Enter pickup and drop location"
                        value="<?php echo isset($_SESSION['form_data']['pickup_location']) ? htmlentities($_SESSION['form_data']['pickup_location']) : ''; ?>">
                </div>
              
                <div class="document-upload">
                  <label for="national_id">National ID / Passport:</label>
                  <input type="file" name="national_id" id="national_id" accept="image/*" required>
                  <p class="file-requirements">Max 2MB, JPG/PNG/GIF only</p>
                </div>
       
        <div class="document-upload">
          <label for="driving_license">Driving License:</label>
          <input type="file" name="driving_license" id="driving_license" accept="image/*" required>
          <p class="file-requirements">Max 2MB, JPG/PNG/GIF only</p>
        </div>
       
        <div class="form-group">
          <label>Message:</label>
          <textarea class="form-control" name="message" rows="3" placeholder="Any special requirements?"><?php echo isset($_SESSION['form_data']['message']) ? htmlentities($_SESSION['form_data']['message']) : ''; ?></textarea>
        </div>
        
        <?php if(isset($_SESSION['login'])): ?>
          <div class="form-group">
            <input type="submit" class="btn" name="submit" value="Book Now">
          </div>
        <?php else: ?>
          <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>
        <?php endif; ?>
      </form>
  <?php endif; ?>
  <?php unset($_SESSION['form_data']); ?>
</div>
      </aside>
      <!--/Side-Bar-->
    </div>
   
    <div class="space-20"></div>
    <div class="divider"></div>
   
    <!--Similar-Cars-->
    <div class="similar_cars">
      <h3>Similar Cars</h3>
      <div class="row">
        <?php
        $bid=$_SESSION['brndid'];
        $sql="SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,
              tblvehicles.FuelType,tblvehicles.ModelYear,tblvehicles.id,
              tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,
              tblvehicles.Vimage1
              FROM tblvehicles
              JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand
              WHERE tblvehicles.VehiclesBrand=:bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid',$bid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0) {
            foreach($results as $result) { 
        ?>      
        <div class="col-md-3 col-sm-6 mb-4 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img">
              <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image" />
              </a>
            </div>
            <div class="product-listing-content">
              <h5>
                <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                  <?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?>
                </a>
              </h5>
              <p class="list-price">Rs.<?php echo htmlentities($result->PricePerDay);?></p>
              <ul class="features_list list-unstyled">
                <li><i class="fa fa-user" aria-hidden="true"></i> <?php echo htmlentities($result->SeatingCapacity);?> seats</li>
                <li><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo htmlentities($result->ModelYear);?> model</li>
                <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo htmlentities($result->FuelType);?></li>
              </ul>
            </div>
          </div>
        </div>
        <?php }} ?>
      </div>
    </div>
    <!--/Similar-Cars-->
  </div>
</section>
<!--/Listing-detail-->

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer-->

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top-->

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form -->

<!--Register-Form -->
<?php include('includes/registration.php');?>
<!--/Register-Form -->

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

<script>
function validateBookingForm() {
    // Check if user is logged in
    <?php if(!isset($_SESSION['login'])) { ?>
        window.location.href = 'login.php?return_url=' + encodeURIComponent(window.location.href);
        return false;
    <?php } ?>

    // Date validation
    var fromDate = new Date(document.getElementById('fromdate').value);
    var toDate = new Date(document.getElementById('todate').value);
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (fromDate < today) {
        alert("From date cannot be in the past");
        return false;
    }
    
    if (toDate < today) {
        alert("To date cannot be in the past");
        return false;
    }
    
    if (fromDate > toDate) {
        alert("From date cannot be after To date");
        return false;
    }
    
    // Validate pickup location
    var pickupLocation = document.getElementById('pickup_location').value.trim();
    if (!pickupLocation) {
        alert("Please enter a pickup and drop location");
        return false;
    }

    // File validation
    var nationalId = document.getElementById('national_id');
    var drivingLicense = document.getElementById('driving_license');
    
    if (!nationalId.files.length || !drivingLicense.files.length) {
        alert("Please upload both required documents");
        return false;
    }
    
    // File type and size validation
    var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    var maxSize = 2 * 1024 * 1024; // 2MB
    
    if (nationalId.files.length > 0) {
        var file = nationalId.files[0];
        if (!allowedTypes.includes(file.type)) {
            alert("National ID/Passport must be a JPG, PNG, or GIF image");
            return false;
        }
        if (file.size > maxSize) {
            alert("National ID/Passport image must be less than 2MB");
            return false;
        }
    }
    
    if (drivingLicense.files.length > 0) {
        var file = drivingLicense.files[0];
        if (!allowedTypes.includes(file.type)) {
            alert("Driving License must be a JPG, PNG, or GIF image");
            return false;
        }
        if (file.size > maxSize) {
            alert("Driving License image must be less than 2MB");
            return false;
        }
    }
    
    return true;
}
</script>

</body>
</html>