<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
}
else {
?><!DOCTYPE HTML>
<html lang="en">
<head>
<title>Car Rental Portal - My Booking</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
        
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<!-- Google-Font-->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

<style>
    /* Payment method styles */
    .payment-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .payment-options {
        width: 55%;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .summary {
        width: 40%;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .payment-method {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .method {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .method:hover {
        border-color: #007BFF;
    }
    
    .method.active {
        border-color: #007BFF;
        background-color: #e7f1ff;
    }
    
    .method img {
        width: 50px;
        margin-right: 15px;
    }
    
    .method-content {
        flex-grow: 1;
    }
    
    .method-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .method-desc {
        color: #666;
        font-size: 14px;
    }
    
    .payment-btn {
        width: 100%;
        padding: 12px;
        background-color: orange;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }
    
    .payment-btn:hover {
        background-color: darkorange;
    }
    
    .summary h2 {
        margin-top: 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .summary p {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
    }
    
    .summary .total {
        font-weight: bold;
        font-size: 18px;
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }
    
    @media (max-width: 768px) {
        .payment-container {
            flex-direction: column;
        }
        
        .payment-options, .summary {
            width: 100%;
            margin-bottom: 20px;
        }
    }
    
    /* Invoice table styles */
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .invoice-table th, .invoice-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    
    .invoice-table th {
        background-color: #f2f2f2;
    }
    
    .invoice-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    /* Add this to your existing CSS */
.vehicle-status-container {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 10px;
}

.pay-now-btn {
    background-color: #4CAF50;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s;
}

.pay-now-btn:hover {
    background-color: #45a049;
    text-decoration: none;
}

.pay-now-btn p {
    color: white;
    margin: 0;
}
</style>
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  
        
<!--Header-->
<?php include('includes/header.php');?>
<!--Page Header-->
<!-- /Header --> 

<!--Page Header-->
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>My Booking</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>My Booking</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 
<?php if (isset($_SESSION['payment_success'])): ?>
    <div class="alert alert-success" style="margin-top: 20px;">
        <?php 
        echo htmlentities($_SESSION['payment_success']); 
        unset($_SESSION['payment_success']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['payment_error'])): ?>
    <div class="alert alert-danger" style="margin-top: 20px;">
        <?php 
        echo htmlentities($_SESSION['payment_error']); 
        unset($_SESSION['payment_error']);
        ?>
    </div>
<?php endif; ?>

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail ";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image">
      </div>

      <div class="dealer_info">
        <h5><?php echo htmlentities($result->FullName);?></h5>
        <p><?php echo htmlentities($result->Address);?><br>
          <?php echo htmlentities($result->City);?>&nbsp;<?php echo htmlentities($result->Country); }}?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
       <?php include('includes/sidebar.php');?>
      </div>
      
      <div class="col-md-8 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">My Bookings</h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT tblvehicles.Vimage1 as Vimage1,tblvehicles.VehiclesTitle,tblvehicles.id as vid,tblbrands.BrandName,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.Status,tblvehicles.PricePerDay,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tblbooking.BookingNumber, tblbooking.id as booking_id from tblbooking join tblvehicles on tblbooking.VehicleId=tblvehicles.id join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblbooking.userEmail=:useremail order by tblbooking.id desc";
$query = $dbh -> prepare($sql);
$query-> bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
    // Check if payment form should be shown
    $show_payment = false;
    if(isset($_GET['pay']) && $_GET['pay'] == $result->booking_id && $result->Status == 1) {
        $show_payment = true;
    }
?>

<li>
    <h4 style="color:red">Booking No #<?php echo htmlentities($result->BookingNumber);?></h4>
    <div class="vehicle_img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
    <div class="vehicle_title">
        <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid);?>"> <?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></a></h6>
        <p><b>From </b> <?php echo htmlentities($result->FromDate);?> <b>To </b> <?php echo htmlentities($result->ToDate);?></p>
        <div style="float: left"><p><b>Message:</b> <?php echo htmlentities($result->message);?> </p></div>
    </div>
    <?php if($result->Status==1) { ?>
        <div style="display: flex; align-items: center; gap: 100px; margin: 10px 0;">
            <div class="vehicle_status" style="margin: 0;"> 
                <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
            </div>
            <?php if(!$show_payment) { ?>
                <a href="my-booking.php?pay=<?php echo $result->booking_id; ?>" 
                   style="display: inline-block; background: #4CAF50; color: white; padding: 6px 15px; 
                          border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500;
                          transition: all 0.3s ease;">
                   <span>   Pay Now</span>
                </a>
            <?php } ?>
        </div>
    <?php } else if($result->Status==2) { ?>
        <div class="vehicle_status"> 
            <a href="#" class="btn outline btn-xs">Cancelled</a>
            <div class="clearfix"></div>
        </div>
    <?php } else { ?>
        <div class="vehicle_status"> 
            <a href="#" class="btn outline btn-xs">Not Confirm yet</a>
            <div class="clearfix"></div>
        </div>
    <?php } ?>
</li>

<!-- Invoice Table -->
<table class="invoice-table">
  <tr>
    <th>Car Name</th>
    <th>From Date</th>
    <th>To Date</th>
    <th>Total Days</th>
    <th>Rent / Day</th>
  </tr>
  <tr>
    <td><?php echo htmlentities($result->VehiclesTitle);?>, <?php echo htmlentities($result->BrandName);?></td>
    <td><?php echo htmlentities($result->FromDate);?></td>
    <td><?php echo htmlentities($result->ToDate);?></td>
    <td><?php echo htmlentities($tds=$result->totaldays);?></td>
    <td><?php echo htmlentities($ppd=$result->PricePerDay);?></td>
  </tr>
  <tr>
    <th colspan="4" style="text-align:center;">Grand Total</th>
    <th><?php echo htmlentities($tds*$ppd);?></th>
  </tr>
</table>

<?php if($show_payment) { ?>
    <!-- Payment Section -->
    <div class="payment-container" id="payment-section-<?php echo $result->booking_id; ?>">
        <div class="payment-options">
            <h3>Payment Options</h3>
            <form action="process-payment.php" method="post">
                <input type="hidden" name="booking_id" value="<?php echo $result->booking_id; ?>">
                <input type="hidden" name="amount" value="<?php echo $tds*$ppd; ?>">
                
                <div class="payment-method">
                    <div class="method active" onclick="selectMethod(this, 'cash')">
                        
                        <div class="method-content">
                            <div class="method-title">Cash on Delivery</div>
                            <div class="method-desc">Pay when you receive the vehicle</div>
                        </div>
                        <input type="radio" name="payment_method" value="cash" checked style="display: none;">
                    </div>
                    
                    <div class="method" onclick="selectMethod(this, 'khalti')">
                      
                        <div class="method-content">
                            <div class="method-title">Pay with Khalti</div>
                            <div class="method-desc">Secure online payment</div>
                        </div>
                        <input type="radio" name="payment_method" value="khalti" style="display: none;">
                    </div>
                    
                    
                </div>
                
                <button type="submit" class="payment-btn">Complete Payment</button>
            </form>
        </div>
        
        <div class="summary">
            <h3>Booking Summary</h3>
            <p>Vehicle: <span><?php echo htmlentities($result->BrandName);?> <?php echo htmlentities($result->VehiclesTitle);?></span></p>
            <p>From: <span><?php echo htmlentities($result->FromDate);?></span></p>
            <p>To: <span><?php echo htmlentities($result->ToDate);?></span></p>
            <p>Total Days: <span><?php echo htmlentities($tds=$result->totaldays);?></span></p>
            <p>Price Per Day: <span>Rs. <?php echo htmlentities($ppd=$result->PricePerDay);?></span></p>
            <p class="total">Total Amount: <span>Rs. <?php echo htmlentities($tds*$ppd);?></span></p>
        </div>
    </div>
<?php } ?>

<hr />
<?php }} else { ?>
    <h5 align="center" style="color:red">No booking yet</h5>
<?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/my-vehicles--> 

<script>
function selectMethod(methodElement, methodValue) {
    // Remove active class from all methods in the same container
    const container = methodElement.closest('.payment-method');
    container.querySelectorAll('.method').forEach(method => {
        method.classList.remove('active');
    });
    
    // Add active class to selected method
    methodElement.classList.add('active');
    
    // Update the corresponding radio button
    methodElement.querySelector('input[type="radio"]').checked = true;
}

// Scroll to payment section if pay parameter is in URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const payId = urlParams.get('pay');
    
    if(payId) {
        const paymentSection = document.getElementById('payment-section-' + payId);
        if(paymentSection) {
            paymentSection.scrollIntoView({ behavior: 'smooth' });
        }
    }
});
</script>

<?php include('includes/footer.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>