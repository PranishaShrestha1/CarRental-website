<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>DriveEase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap 3 CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      overflow-x: hidden;
      background-color: #f8f9fa;
    }

   
    .default-header .container-fluid {
      display: flex;
      align-items: center; 
      justify-content: space-between;
      padding: 10px 15px;
      background: #f8f9fa;
      border-bottom: 1px solid #eaeaea;
    }

 
    .logo-text {
      flex-shrink: 0;
    }
    .brand-name {
      font-size: 28px;
      font-weight: 700;
      color: #2c3e50;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      text-decoration: none;
      line-height: 1; 
    }
    .brand-name span {
      color: #e74c3c;
    }

 
    nav.navbar {
      margin: 0;
      padding: 0;
      background: transparent;
      border: none;
      flex-grow: 1; 
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .navbar-nav {
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
    }
    .navbar-nav > li {
      float: none; 
      display: inline-block;
      margin-left: 15px;
    }
    .navbar-nav > li > a {
      color: #333;
      font-weight: 500;
      padding: 10px 12px;
    }
    .navbar-nav > li > a:hover {
      color: #e74c3c;
    }


    .navbar-nav.navbar-right {
      display: flex;
      align-items: center;
      gap: 15px;
      margin: 0;
    }

    .user_login .dropdown-menu {
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
      min-width: 180px;
      padding: 5px 0;
      z-index: 1000;
    }
    .user_login .dropdown-menu > li > a {
      color: #333 !important;
      font-weight: 600;
      padding: 10px 20px;
      display: block;
    }
    .user_login .dropdown-menu > li > a:hover {
      background-color: #e0e0e0;
      color: #000 !important;
      text-decoration: none;
    }
    .user_login a,
    .user_login .dropdown a i {
      color: #333 !important;
      font-weight: 500;
      white-space: nowrap;
    }

    #header-search-form {
      display: flex;
      margin: 0;
    }
    #header-search-form input {
      width: 180px;
      border: 1px solid #bbb;
      background-color: #fff;
      color: #333;
      height: 34px;
      padding: 6px 12px;
      font-size: 14px;
      border-radius: 3px 0 0 3px;
      outline: none;
    }
    #header-search-form input::placeholder {
      color: #888;
    }
    #header-search-form button {
      background-color: #e74c3c;
      color: #fff;
      border: none;
      padding: 6px 12px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 0 3px 3px 0;
      height: 34px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #header-search-form button:hover {
      background-color: #c0392b;
    }

    @media (max-width: 767px) {
      .default-header .container-fluid {
        flex-wrap: wrap;
      }
      nav.navbar {
        flex-basis: 100%;
        margin-top: 10px;
        justify-content: center;
      }
      .navbar-nav.navbar-right {
        flex-wrap: wrap;
        justify-content: center;
      }
      #header-search-form {
        width: 100%;
        margin-top: 10px;
      }
      #header-search-form input {
        width: 100%;
        border-radius: 3px 3px 0 0;
      }
      #header-search-form button {
        width: 100%;
        border-radius: 0 0 3px 3px;
        padding: 10px 0;
      }
    }
  </style>
</head>
<body>
  <div class="default-header">
    <div class="container-fluid">
      <div class="logo-text">
        <a href="index.php" class="brand-name">Drive <span>Ease</span></a>
      </div>
      <nav class="navbar navbar-default" role="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="page.php?type=aboutus">About Us</a></li>
          <li><a href="car-listing.php">Car Listing</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown user_login">
            <?php if(strlen($_SESSION['login']) == 0) { ?>
              <a href="#loginform" data-toggle="modal" data-dismiss="modal">
                <i class="fa fa-user-circle" aria-hidden="true"></i> <span>Login</span>
              </a>
            <?php } else {
              $email = $_SESSION['login'];
              $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email";
              $query = $dbh->prepare($sql);
              $query->bindParam(':email', $email, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
            ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <?php
                  if($query->rowCount() > 0) {
                    foreach($results as $result) {
                      echo htmlentities($result->FullName);
                    }
                  }
                ?>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="profile.php">Profile Settings</a></li>
                <li><a href="update-password.php">Update Password</a></li>
                <li><a href="my-booking.php">My Booking</a></li>
                <li><a href="post-testimonial.php">Post a Testimonial</a></li>
                <li><a href="my-testimonials.php">My Testimonial</a></li>
                <li><a href="logout.php">Sign Out</a></li>
              </ul>
            <?php } ?>
          </li>

          <li>
            <form action="search.php" method="post" id="header-search-form" class="search-form">
              <input type="text" name="searchdata" class="form-control input-sm" placeholder="Search..." required />
              <button type="submit" class="btn btn-sm"><i class="fa fa-search"></i></button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>