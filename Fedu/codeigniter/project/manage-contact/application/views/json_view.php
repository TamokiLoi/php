<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>View Data</title>
	<script type="text/javascript" src="<?php echo base_url() ?>vendor/bootstrap.js"></script>
 	<script type="text/javascript" src="<?php echo base_url() ?>1.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/font-awesome.css">
 	<link rel="stylesheet" href="<?php echo base_url() ?>1.css">
</head>
<body>
	<?php include "menu.php"; ?>
	<div class="container">
		<div class="card-deck-wrapper">
			<div class="card-deck">
				<?php foreach ($items as $key => $value): ?>
					<div class="card">
						<div class="card-block">
							<h4 class="card-title">Name: <?= $value->name ?></h4>
							<p class="card-text">Tel: <?= $value->phone_number ?></p>
							<a href="json/delete_json/<?= $value->phone_number ?>" class="btn btn-danger"> <i class="fa fa-remove"></i></a>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>

	<div class="container">
		<form method="post" action="json/add_json">
			<fieldset class="form-group">
				<label for="formGroupExampleInput">Name</label>
				<input name="name" type="text" class="form-control" id="formGroupExampleInput" placeholder="input name">
			</fieldset>
			<fieldset class="form-group">
				<label for="formGroupExampleInput2">Phone Number</label>
				<input name="phone_number" type="text" class="form-control" id="formGroupExampleInput2" placeholder="input phone number">
			</fieldset>
			<fieldset class="form-group">
				<input type="submit" class="form-control btn btn-danger" value="Submit">
			</fieldset>
		</form>
	</div>
	
</body>
</html>