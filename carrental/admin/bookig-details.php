<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
    if(isset($_REQUEST['eid'])) {
        $eid=intval($_GET['eid']);
        $status="2";
        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':status',$status, PDO::PARAM_STR);
        $query-> bindParam(':eid',$eid, PDO::PARAM_STR);
        $query -> execute();
        echo "<script>alert('Booking Successfully Cancelled');</script>";
        echo "<script type='text/javascript'> document.location = 'canceled-bookings.php'; </script>";
    }

    if(isset($_REQUEST['aeid'])) {
        $aeid=intval($_GET['aeid']);
        $status=1;

        $sql = "UPDATE tblbooking SET Status=:status WHERE id=:aeid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':status',$status, PDO::PARAM_STR);
        $query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
        $query -> execute();
        echo "<script>alert('Booking Successfully Confirmed');</script>";
        echo "<script type='text/javascript'> document.location = 'confirmed-bookings.php'; </script>";
    }
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    
    <title>Car Rental Portal | Booking Details</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .document-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            margin: 5px 0;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .document-img:hover {
            transform: scale(1.03);
        }
        .document-container {
            margin: 15px 0;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .document-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .document-viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }
        .document-viewer img {
            max-width: 90%;
            max-height: 90%;
            border: 2px solid #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        .close-viewer {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }
        .close-viewer:hover {
            color: #ddd;
        }
        .btn-document {
            margin: 5px;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php');?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Booking Details</h2>
                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Bookings Info</div>
                            <div class="panel-body">
                                <div id="print">
                                    <table border="1" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <tbody>
                                            <?php 
                                            $bid=intval($_GET['bid']);
                                            $sql = "SELECT tblusers.*,tblbrands.BrandName,tblvehicles.VehiclesTitle,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.VehicleId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id,tblbooking.BookingNumber,tblbooking.NationalIdPath,tblbooking.DrivingLicensePath,
                                            DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totalnodays,tblvehicles.PricePerDay
                                            from tblbooking join tblvehicles on tblvehicles.id=tblbooking.VehicleId join tblusers on tblusers.EmailId=tblbooking.userEmail join tblbrands on tblvehicles.VehiclesBrand=tblbrands.id where tblbooking.id=:bid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':bid',$bid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0) {
                                                foreach($results as $result) { 
                                            ?>    
                                            <h3 style="text-align:center; color:red">#<?php echo htmlentities($result->BookingNumber);?> Booking Details </h3>

                                            <tr>
                                                <th colspan="4" style="text-align:center;color:blue">User Details</th>
                                            </tr>
                                            <tr>
                                                <th>Booking No.</th>
                                                <td>#<?php echo htmlentities($result->BookingNumber);?></td>
                                                <th>Name</th>
                                                <td><?php echo htmlentities($result->FullName);?></td>
                                            </tr>
                                            <tr>                                            
                                                <th>Email Id</th>
                                                <td><?php echo htmlentities($result->EmailId);?></td>
                                                <th>Contact No</th>
                                                <td><?php echo htmlentities($result->ContactNo);?></td>
                                            </tr>
                                            <tr>                                            
                                                <th>Address</th>
                                                <td><?php echo htmlentities($result->Address);?></td>
                                                <th>City</th>
                                                <td><?php echo htmlentities($result->City);?></td>
                                            </tr>
                                            <tr>                                            
                                                <th>Country</th>
                                                <td colspan="3"><?php echo htmlentities($result->Country);?></td>
                                            </tr>

                                            <tr>
                                                <th colspan="4" style="text-align:center;color:blue">Booking Details</th>
                                            </tr>
                                            <tr>                                            
                                                <th>Vehicle Name</th>
                                                <td><a href="edit-vehicle.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></td>
                                                <th>Booking Date</th>
                                                <td><?php echo htmlentities($result->PostingDate);?></td>
                                            </tr>
                                            <tr>
                                                <th>From Date</th>
                                                <td><?php echo htmlentities($result->FromDate);?></td>
                                                <th>To Date</th>
                                                <td><?php echo htmlentities($result->ToDate);?></td>
                                            </tr>
                                            <tr>
                                                <th>Total Days</th>
                                                <td><?php echo htmlentities($tdays=$result->totalnodays);?></td>
                                                <th>Rent Per Days</th>
                                                <td><?php echo htmlentities($ppdays=$result->PricePerDay);?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" style="text-align:center">Grand Total</th>
                                                <td><?php echo htmlentities($tdays*$ppdays);?></td>
                                            </tr>
                                            <tr>
                                                <th>Booking Status</th>
                                                <td><?php 
                                                if($result->Status==0) {
                                                    echo htmlentities('Not Confirmed yet');
                                                } else if ($result->Status==1) {
                                                    echo htmlentities('Confirmed');
                                                } else {
                                                    echo htmlentities('Cancelled');
                                                }
                                                ?></td>
                                                <th>Last Updation Date</th>
                                                <td><?php echo htmlentities($result->LastUpdationDate);?></td>
                                            </tr>

                                            <tr>
                                                <th colspan="4" style="text-align:center;color:blue">User Documents</th>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="row">
                                                        <div class="col-md-6 document-container">
                                                            <div class="document-title">National ID / Passport</div>
                                                            <?php 
                                                            if(!empty($result->NationalIdPath)): 
                                                                // Fix path if it includes 'admin/' prefix
                                                                $nationalIdPath = str_replace('admin/', '', $result->NationalIdPath);
                                                                // Verify file exists
                                                                if(file_exists($nationalIdPath)):
                                                            ?>
                                                                <img src="<?php echo htmlentities($nationalIdPath); ?>" 
                                                                     class="document-img" 
                                                                     alt="National ID/Passport" 
                                                                     onclick="viewDocument('<?php echo htmlentities($nationalIdPath); ?>')">
                                                                <div>
                                                                    <button onclick="viewDocument('<?php echo htmlentities($nationalIdPath); ?>')" 
                                                                            class="btn btn-sm btn-primary btn-document">
                                                                        <i class="fa fa-eye"></i> View Full Image
                                                                    </button>
                                                                    <a href="download-document.php?file=<?php echo urlencode($nationalIdPath); ?>" 
                                                                       class="btn btn-sm btn-success btn-document">
                                                                        <i class="fa fa-download"></i> Download
                                                                    </a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-danger">Document file not found</div>
                                                            <?php endif; ?>
                                                            <?php else: ?>
                                                                <div class="text-danger">No document uploaded</div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-6 document-container">
                                                            <div class="document-title">Driving License</div>
                                                            <?php 
                                                            if(!empty($result->DrivingLicensePath)): 
                                                                // Fix path if it includes 'admin/' prefix
                                                                $drivingLicensePath = str_replace('admin/', '', $result->DrivingLicensePath);
                                                                // Verify file exists
                                                                if(file_exists($drivingLicensePath)):
                                                            ?>
                                                                <img src="<?php echo htmlentities($drivingLicensePath); ?>" 
                                                                     class="document-img" 
                                                                     alt="Driving License" 
                                                                     onclick="viewDocument('<?php echo htmlentities($drivingLicensePath); ?>')">
                                                                <div>
                                                                    <button onclick="viewDocument('<?php echo htmlentities($drivingLicensePath); ?>')" 
                                                                            class="btn btn-sm btn-primary btn-document">
                                                                        <i class="fa fa-eye"></i> View Full Image
                                                                    </button>
                                                                    <a href="download-document.php?file=<?php echo urlencode($drivingLicensePath); ?>" 
                                                                       class="btn btn-sm btn-success btn-document">
                                                                        <i class="fa fa-download"></i> Download
                                                                    </a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-danger">Document file not found</div>
                                                            <?php endif; ?>
                                                            <?php else: ?>
                                                                <div class="text-danger">No document uploaded</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <?php if($result->Status==0){ ?>
                                            <tr>    
                                                <td style="text-align:center" colspan="4">
                                                    <a href="bookig-details.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm this booking')" class="btn btn-primary"> Confirm Booking</a> 
                                                    <a href="bookig-details.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Cancel this Booking')" class="btn btn-danger"> Cancel Booking</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <?php $cnt=$cnt+1; }} ?>
                                        </tbody>
                                    </table>
                                    <form method="post">
                                        <input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;"  />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document Viewer Modal -->
    <div id="documentViewer" class="document-viewer">
        <span class="close-viewer" onclick="closeViewer()">&times;</span>
        <img id="viewerImage" src="" alt="Document Viewer">
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
    <script language="javascript" type="text/javascript">
        function f3() {
            window.print(); 
        }
        
        function viewDocument(imagePath) {
            document.getElementById('viewerImage').src = imagePath;
            document.getElementById('documentViewer').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when viewer is open
        }
        
        function closeViewer() {
            document.getElementById('documentViewer').style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
        
        // Close viewer when clicking outside the image
        document.getElementById('documentViewer').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewer();
            }
        });
        
        // Close viewer with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                closeViewer();
            }
        });
    </script>
</body>
</html>
<?php } ?>