<?php
require_once("connection.php");
$bulk = new MongoDB\Driver\BulkWrite;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $user = [
        "_id" => new MongoDB\BSON\ObjectId,
        "username" => $username,
        "email" => $email,
        "password" => $hashedPassword,
    ];
    $bulk->insert($user);
    $client->executeBulkWrite('dbyeartwo.account', $bulk);
   if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
       header('Location: tables.php');
    }else{
        $msg="Vai! Vai! Vai!!!";
    }

    echo 'User registered successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Merrin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        .card {
            border: none;
            border-radius: 10px;
            max-width: 500px; /* Set maximum width */
            margin: 20px auto; /* Center horizontally */
        }

        .card-body {
            background-color: #f8d7da; /* Light red color */
            border-radius: 10px;
            padding: 30px;
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
        }

        .form-control {
            border-radius: 50px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .custom-control-label::before,
        .custom-control-label::after {
            border-radius: 50px;
        }

        .text-center .small {
            color: #6c757d;
        }

        .form-container {
            background-color: #f8d7da; /* Light red color */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-5 form-container">
                        <!-- Nested Row within Card Body -->
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" action="register.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Username" name="username">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.php">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

