<?php
session_start();

require_once ("connection.php");
$query = new MongoDB\Driver\Query([]);
$cursor = $client->executeQuery('dbyeartwo.account', $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isValid = false;
    foreach ($cursor as $document) {
        if ($document->email == $email) {
            if (password_verify($password, $document->password)) {
                $isValid = true;
                $user = $document;
                break;
            } else {
                echo "Invalid password.";
            }
        }
    }

    if ($isValid) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user'] = $user->username;

        if (isset($_POST['remember'])) {
            setcookie('email', $email, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");
        } else {
            setcookie('email', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid email or password.';
        echo $error;
    }

   
} else {
    if (isset ($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
        $checked = true;
    } else {
        $email = '';
        $password = '';
        $checked = false;
    }
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
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
                        <form class="user" action="login.php" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Enter Email Address..." value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" value="<?php echo htmlspecialchars($password) ?>">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" checked=<?php echo $checked ?>>
                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="register.php">Create an Account!</a>
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
