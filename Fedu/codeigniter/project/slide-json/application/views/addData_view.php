<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New Data Slide</title>
	<script type="text/javascript" src="<?= base_url() ?>vendor/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>1.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>vendor/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url() ?>1.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 offset-sm-3">
				<h3 class="text-center">Add New Slide</h3>
				<hr>
				<form method="POST" action="slides/addSlide" enctype="multipart/form-data">
					<fieldset class="form-group">
						<label for="formGroupExampleInput">Title Slide</label>
						<input name="title" type="text" class="form-control" id="title" placeholder="title">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Description Slide</label>
						<input name="description" type="text" class="form-control" id="description" placeholder="description">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Button Link</label>
						<input name="button_link" type="text" class="form-control" id="button_link" placeholder="button link">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Button Text</label>
						<input name="button_text" type="text" class="form-control" id="button_text" placeholder="button text">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Upload Images</label>
						<input name="slide_image" type="file" class="form-control" id="slide_image">
					</fieldset>

					<fieldset class="form-group">
						<input type="submit" class="form-control btn btn-outline-info" value="Add New">
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
</html>