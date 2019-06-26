<!DOCTYPE html>
<html lang="en"><head>
	<title>Edit Employees</title>
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
 		<div class="container">
	 		<div class="text-xs-center">
	 			<h4 class="display-3">Edit Employee</h4>
	 			<hr>
	 		</div>
 		</div>

 		<form method="post" enctype="multipart/form-data" action="<?= base_url() ?>index.php/employee/update_employee">

 			<?php foreach ($data as $item): ?>
 			<div class="form-group row">
 				<!-- avatar-image -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="avatar_image" class="col-sm-4 form-control-label text-xs-right">Avatar Image</label>
 						<div class="col-sm-8">
 							<div class="row">
 								<div class="col-sm-6">
 									<img src="<?= $item['avatar_image'] ?>" alt="image" class="img-fluid"></img>
 								</div>
 							</div>
 							<input type="hidden" name="id" value="<?= $item['id'] ?>">
 							<input type="hidden" name="avatar_image_old" value="<?= $item['avatar_image'] ?>">
 							<input name="avatar_image" type="file" class="form-control" id="avatar_image" placeholder="Upload Avatar Image">
 						</div>
 					</div>
 				</div>

 				<!-- name -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="name" class="col-sm-4 form-control-label text-xs-right">Name</label>
 						<div class="col-sm-8">
 							<input value="<?= $item['name'] ?>" name="name" type="text" class="form-control" id="name" placeholder="input name employee">
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
 							<input value="<?= $item['age'] ?>" name="age" type="number" class="form-control" id="age" placeholder="input age employee">
 						</div>
 					</div>
 				</div>

 				<!-- phone_number -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="phone_number" class="col-sm-4 form-control-label text-xs-right">Phone</label>
 						<div class="col-sm-8">
 							<input value="<?= $item['phone_number'] ?>" name="phone_number" type="text" class="form-control" id="phone_number" placeholder="input phone number">
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
 							<input value="<?= $item['order_amount'] ?>" name="order_amount" type="text" class="form-control" id="order_amount" placeholder="input order amount">
 						</div>
 					</div>
 				</div>

 				<!-- link_fb -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="link_fb" class="col-sm-4 form-control-label text-xs-right">Facebook</label>
 						<div class="col-sm-8">
 							<input value="<?= $item['link_fb'] ?>" name="link_fb" type="text" class="form-control" id="link_fb" placeholder="input link facebook">
 						</div>
 					</div>
 				</div>
 			</div>
 			<?php endforeach ?>

 			<!-- button submit -->
 			<div class="form-group row text-xs-center">
 				<div class="col-sm-12">
 					<button type="submit" class="btn btn-outline-success">Update</button>
 					<a href="<?= base_url() ?>index.php/employee" class="btn btn-outline-info">Back</a>
 				</div>
 			</div>
 		</form>
 	</div>
</body>
</html>