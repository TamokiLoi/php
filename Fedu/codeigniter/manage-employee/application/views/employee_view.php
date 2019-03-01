<!DOCTYPE html>
<html lang="en"><head>
	<title>Show List Employees</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	<script type="text/javascript" src="<?php echo base_url() ?>vendor/bootstrap.js"></script>
 	<script type="text/javascript" src="<?php echo base_url() ?>1.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/font-awesome.css">
 	<link rel="stylesheet" href="<?php echo base_url() ?>1.css">
</head>
<body >
 	<div class="container">
 		<div class="text-xs-center">
 			<h3 class="display-3">List Employees</h3>
 			<hr>
 		</div>
 	</div>

 	<div class="container">
 		<div class="row">
 			<!-- begin card-columns -->
 			<?php foreach ($list_employees as $item): ?>
 			<div class="col-sm-4">
 				<div class="card">
 					<img class="card-img-top img-fluid" src="<?= $item['avatar_image'] ?>" alt="Card image cap">
 					<div class="card-block">	
 						<h4 class="card-title name"><?= $item['name'] ?></h4>
 						<p class="card-text age">Age: <b><?= $item['age'] ?></b></p>
 						<p class="card-text tel">Tel: <b><?= $item['phone_number'] ?></b></p>
 						<p class="card-text order-amount">Order Amount Complete: <?= $item['order_amount'] ?></p>
 						<p class="card-text link-fb">
 							<small><a href="<?= $item['link_fb'] ?>" class="btn btn-info btn-xs" target="_blank">
 								Facebook <i class="fa fa-chevron-right"></i></a>
 							</small>
 							<small><a href="<?= base_url() ?>index.php/employee/edit_employee" class="btn btn-warning btn-xs">
 								Edit <i class="fa fa-pencil"></i></a>
 							</small>
 							<small><a href="<?= base_url() ?>index.php/employee/delete_employee" class="btn btn-danger btn-xs">
 								Delete <i class="fa fa-remove"></i></a>
 							</small>
 						</p>
 						<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
 					</div>
 				</div>
 			</div>
 			<?php endforeach ?>
 			<!-- end card-columns -->
 		</div>

 		<div class="container">
	 		<div class="text-xs-center">
	 			<h4 class="display-3">Add New Employee</h4>
	 			<hr>
	 		</div>
 		</div>

 		<form method="post" enctype="multipart/form-data" action="<?= base_url() ?>index.php/employee/add_employee">
 			<div class="form-group row">
 				<!-- avatar-image -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="avatar_image" class="col-sm-4 form-control-label text-xs-right">Avatar Image</label>
 						<div class="col-sm-8">
 							<input name="avatar_image" type="file" class="form-control" id="avatar_image" placeholder="Upload Avatar Image">
 						</div>
 					</div>
 				</div>

 				<!-- name -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="name" class="col-sm-4 form-control-label text-xs-right">Name</label>
 						<div class="col-sm-8">
 							<input name="name" type="text" class="form-control" id="name" placeholder="input name employee">
 						</div>
 					</div>
 				</div>
 			</div>

 			<div class="form-group row">
 				<!-- age -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="age" class="col-sm-4 form-control-label text-xs-right">Age</label>
 						<div class="col-sm-8">
 							<input name="age" type="number" class="form-control" id="age" placeholder="input age employee">
 						</div>
 					</div>
 				</div>

 				<!-- phone_number -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="phone_number" class="col-sm-4 form-control-label text-xs-right">Phone</label>
 						<div class="col-sm-8">
 							<input name="phone_number" type="text" class="form-control" id="phone_number" placeholder="input phone number">
 						</div>
 					</div>
 				</div>
 			</div>

 			<div class="form-group row">
 				<!-- order_amount -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="order_amount" class="col-sm-4 form-control-label text-xs-right">Order Amount</label>
 						<div class="col-sm-8">
 							<input name="order_amount" type="text" class="form-control" id="order_amount" placeholder="input order amount">
 						</div>
 					</div>
 				</div>

				<!-- link_fb -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="link_fb" class="col-sm-4 form-control-label text-xs-right">Facebook</label>
 						<div class="col-sm-8">
 							<input name="link_fb" type="text" class="form-control" id="link_fb" placeholder="input link facebook">
 						</div>
 					</div>
 				</div>
 			</div>


 			<!-- button submit -->
 			<div class="form-group row text-xs-center">
 				<div class="col-sm-12">
 					<button type="submit" class="btn btn-outline-success">Add New</button>
 					<button type="reset" class="btn btn-outline-danger">Reset</button>
 				</div>
 			</div>
 		</form>
 	</div>
</body>
</html>