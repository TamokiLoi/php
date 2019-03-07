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
	
</body>
</html>