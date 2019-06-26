<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Data</title>
	<script type="text/javascript" src="<?php echo base_url() ?>vendor/bootstrap.js"></script>
 	<script type="text/javascript" src="<?php echo base_url() ?>1.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>vendor/font-awesome.css">
 	<link rel="stylesheet" href="<?php echo base_url() ?>1.css">
</head>
<body>
	<?php include "menu.php"; ?>
	<div class="container">
		<form method="post" action="jsonEdit/edit_json">
			<?php $index = 0;  ?>
			<?php foreach ($arrayData as $key): ?>
				<?php $index++; ?>
				<h2>Contact no: <?= $index ?></h2>
				<hr>
				<fieldset class="form-group">
					<label for="formGroupExampleInput">Name</label>
					<input value="<?= $key['name'] ?>" name="name[]" type="text" class="form-control" id="formGroupExampleInput" placeholder="input name">
				</fieldset>
				<fieldset class="form-group">
					<label for="formGroupExampleInput2">Phone Number</label>
					<input value="<?= $key['phone_number'] ?>" name="phone_number[]" type="text" class="form-control" id="formGroupExampleInput2" placeholder="input phone number">
				</fieldset>

			<?php endforeach ?>
			<fieldset class="form-group">
				<input type="submit" class="form-control btn btn-success" value="Update">
			</fieldset>
		</form>
	</div>
</body>
</html>