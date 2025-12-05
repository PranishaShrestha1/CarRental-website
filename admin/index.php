<?php
session_start();
include('includes/config.php');
if (isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT UserName,Password FROM admin WHERE UserName=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
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

    <title>Admin Login | Car Rental Portal</title>

    <!-- External CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Custom CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-page {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            
        }

        .form-content {
            background-color: rgba(238, 236, 236, 0.96);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 420px;
            width: 100%;
        }

        .form-content h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 15px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            box-shadow: none;
        }

        label {
            font-weight: 600;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 16px;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-content p {
            text-align: center;
            margin-top: 20px;
        }

        .form-content p a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .form-content p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-page">
        <div class="form-content">
            <h1>Admin | Sign In</h1>
            <form method="post">
                <label for="username" class="text-uppercase text-sm">Your Username</label>
                <input type="text" placeholder="Enter Username" name="username" class="form-control" required>

                <label for="password" class="text-uppercase text-sm">Password</label>
                <input type="password" placeholder="Enter Password" name="password" class="form-control" required>

                <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
            </form>
            <p><a href="../index.php">Back to Home</a></p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
