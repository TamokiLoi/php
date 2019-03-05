<!DOCTYPE html>
<html lang="en"><head>
	<title>Show List Employees</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	<script type="text/javascript" src="<?php echo base_url() ?>vendor/bootstrap.js"></script>
	<!-- jquery upload -->
	<script type="text/javascript" src="<?php echo base_url() ?>jqueryUpload/js/vendor/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>jqueryUpload/js/jquery.fileupload.js"></script>
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
 			<div class="card-deck-wrapper">
 				<div class="card-deck">
 					<?php foreach ($list_employees as $item): ?>
 						<div class="col-sm-4 mb-2">
 							<div class="card">
 								<img class="card-img-top img-fluid" src="<?= $item['avatar_image'] ?>" alt="Card image cap">
 								<div class="card-block">	
 									<h4 class="card-title name"><?= $item['name'] ?></h4>
 									<p class="card-text age">Age: <b><?= $item['age'] ?></b></p>
 									<p class="card-text tel">Tel: <b><?= $item['phone_number'] ?></b></p>
 									<p class="card-text order-amount">Order Amount Complete: <?= $item['order_amount'] ?></p>
 									<p class="card-text link-fb">
 										<small><a href="<?= $item['link_fb'] ?>" class="btn btn-info btn-xs" target="_blank">
 											Facebook</a>
 										</small>
 										<small><a href="<?= base_url() ?>index.php/employee/edit_employee/<?= $item['id'] ?>" class="btn btn-warning btn-xs">
 											Edit <i class="fa fa-pencil"></i></a>
 										</small>
 										<small><a href="<?= base_url() ?>index.php/employee/delete_employee/<?= $item['id'] ?>" class="btn btn-danger btn-xs">
 											Delete <i class="fa fa-remove"></i></a>
 										</small>
 									</p>
 									<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
 								</div>
 							</div>
 						</div>
 					<?php endforeach ?>
 				</div>
 			</div>
 			<!-- end card-columns -->
 		</div>

 		<div class="container">
	 		<div class="text-xs-center">
	 			<h4 class="display-3">Add New Employee</h4>
	 			<hr>
	 		</div>
 		</div>

 		<!-- <form method="post" enctype="multipart/form-data" action="<?= base_url() ?>index.php/employee/add_employee"> -->
 			<div class="form-group row">
 				<!-- avatar-image -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="avatar_image" class="col-sm-4 form-control-label text-xs-right">Avatar Image</label>
 						<div class="col-sm-8">
 							<input name="files[]" type="file" class="form-control" id="avatar_image" placeholder="Upload Avatar Image">
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
 				<!-- link_fb -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="link_fb" class="col-sm-4 form-control-label text-xs-right">Facebook</label>
 						<div class="col-sm-8">
 							<input name="link_fb" type="text" class="form-control" id="link_fb" placeholder="input link facebook">
 						</div>
 					</div>
 				</div>

 				<!-- order_amount -->
 				<div class="col-sm-6">
 					<div class="row">
 						<label for="order_amount" class="col-sm-4 form-control-label text-xs-right">Order Amount</label>
 						<div class="col-sm-8">
 							<input name="order_amount" type="text" class="form-control" id="order_amount" placeholder="input order amount">
 						</div>
 					</div>
 				</div>
 			</div>


 			<!-- button submit -->
 			<div class="form-group row text-xs-center">
 				<div class="col-sm-12">
 					<button type="button" class="btn btn-outline-success handle-add-employee">Add New</button>
 					<button type="reset" class="btn btn-outline-danger">Reset</button>
 				</div>
 			</div>
 		<!-- </form> -->
 	</div>

 	<script>
 		url = '<?php echo base_url() ?>';
	    $('#avatar_image').fileupload({
	        url: url + 'index.php/employee/uploadFile',
	        dataType: 'json',
	        done: function (e, data) {
	            $.each(data.result.files, function (index, file) {
	                url_image = file.url;
	            });
	        }
 		});

 		<!-- handle button add employee -->
 		$('.handle-add-employee').click(function(event) {
 			$.ajax({
 				url: 'employee/ajax_add_employee',
 				type: 'POST',
 				dataType: 'json',
 				data: {
 					name: $('#name').val(),
 					age: $('#age').val(),
 					phone_number: $('#phone_number').val(),
	 				avatar_image: url_image,
	 				link_fb: $('#link_fb').val(),
	 				order_amount: $('#order_amount').val()
 				},
 			})
 			.done(function() {
 				console.log("success");

 			})
 			.fail(function() {
 				console.log("error");
 			})
 			.always(function() {
 				console.log("complete");
 				content = '<div class="col-sm-4 mb-2">';
 				content += '<div class="card">';
 				content += '<img class="card-img-top img-fluid" src="' + url_image + '" alt="Card image cap">';
 				content += '<div class="card-block">';
 				content += '<h4 class="card-title name">' + $('#name').val() + '</h4>';
 				content += '<p class="card-text age">Age: ' + $('#age').val() + '</b></p>';
 				content += '<p class="card-text tel">Tel: <b>' + $('#phone_number').val() + '</b></p>';
 				content += '<p class="card-text order-amount">Order Amount Complete: ' + $('#order_amount').val() + '</p>';
 				content += '<p class="card-text link-fb">';
 				content += '<small><a href="' + $('#link_fb').val() + '" class="btn btn-info btn-xs" target="_blank">Facebook</a></small>';
 				content += '<small><a href="<?= base_url() ?>index.php/employee/edit_employee/<?= $item['id'] ?>" class="btn btn-warning btn-xs">Edit <i class="fa fa-pencil"></i></a></small>';
 				content += '<small><a href="<?= base_url() ?>index.php/employee/delete_employee/<?= $item['id'] ?>" class="btn btn-danger btn-xs">Delete <i class="fa fa-remove"></i></a></small></p>';
 				content += '<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>';
 				content += '</div>';
 				content += '</div>';
 				content += '</div>';
 				$('.card-deck').append(content);
 				$('#name').val('');
 				$('#age').val('');
 				$('#phone_number').val('');
 				// avatar_image: $('#avatar_image').val(),
 				$('#link_fb').val('');
 				$('#order_amount').val('');
 			});
 		}); 		
 	</script>
</body>
</html>