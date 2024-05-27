<?php
require_once ("connection.php");

$bulk = new MongoDB\Driver\BulkWrite;
if (!isset($_POST["submit"])) {
	$id = new \MongoDB\BSON\ObjectId($_GET['id']);
	$filter = ['_id' => $id];
	$query = new MongoDB\Driver\Query($filter);
	$article = $client->executeQuery("dbyeartwo.account", $query);
	$doc = current($article->toArray());
} else {
	$target = "images/". basename($_FILES['image']['name']);
	if($target=="images/")
	$data = [
		'username' => $_POST['username'],
		'email' => $_POST['email'],
		'password' => $_POST['password'],
	];
	else
	$data = [
		'username' => $_POST['username'],
		'email' => $_POST['email'],
		'password' => $_POST['password'],
		'image' => $target
	];
	$id = new \MongoDB\BSON\ObjectId($_POST['id']);
	$filter = ['_id' => $id];

	$update = ['$set' => $data];

	$bulk->update($filter, $update);
	$client->executeBulkWrite('dbyeartwo.account', $bulk);
	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		header('Location: tables.php');
	} else {
		header('Location: tables.php');
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

	<title>SB Admin 2 - Tables</title>

	<!-- Custom fonts for this template -->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		
		<!-- Edit User Form -->


		<div class="card-body">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $doc->_id; ?>">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username"
						value="<?php echo $doc->username; ?>">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email"
						value="<?php echo $doc->email; ?>">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password"
						value="<?php echo $doc->password; ?>">
				</div>
				<div class="form-group">
					<label for="image">Image</label>
					<input type="file" class="form-control" id="password" name="image"/>
				</div>
				<img src="<?php echo $doc->image; ?>" width="100px" height="100px"/>
				<input type="submit" name="submit" class="btn btn-primary"/>
			</form>
		</div>



		<!-- Footer -->
		<footer class="sticky-footer bg-white">
			<div class="container my-auto">
				<div class="copyright text-center my-auto">
					<span>Copyright &copy; Your Website 2020</span>
				</div>
			</div>
		</footer>
		<!-- End of Footer -->

	</div>
	<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="logout.php">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<!-- Page level custom scripts -->
	<script src="js/demo/datatables-demo.js"></script>

</body>

</html>