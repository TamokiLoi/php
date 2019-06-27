<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Data Slide</title>
	<script type="text/javascript" src="<?= base_url() ?>vendor/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>1.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>vendor/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url() ?>1.css">
    <link rel="stylesheet" href="<?= base_url() ?>/vendor/bootstrap.css">
</head>
<body>

	<nav class="navbar navbar-light bg-faded">
	  <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">
	    &#9776;
	  </button>
	  <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
	    <a class="navbar-brand" href="#">Backend slide</a>
	    <ul class="nav navbar-nav">
	      <li class="nav-item active">
	        <a class="nav-link" href="<?= base_url() ?>index.php/add_slide">Add slide <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?= base_url() ?>index.php/edit_slide">Edit slide</a>
	      </li>
	    </ul>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-sm-6 offset-sm-3">
				<h3 class="text-center">Edit Slide</h3>
				<?php $count = 0; ?>
				<form method="POST" action="edit_slide/editSlide" enctype="multipart/form-data">
				<?php foreach ($arrayData as $value): ?>
				<hr>
				<?php $count++; ?>
				<h2>Slide number <?= $count; ?></h2>
				<hr>	

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Title Slide</label>
						<input name="title[]" type="text" class="form-control" id="title" 
						value="<?= $value['title'] ?>">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Description Slide</label>
						<input name="description[]" type="text" class="form-control" id="description" value="<?= $value['description'] ?>">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Button Link</label>
						<input name="button_link[]" type="text" class="form-control" id="button_link" value="<?= $value['button_link'] ?>">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Button Text</label>
						<input name="button_text[]" type="text" class="form-control" id="button_text"
						value="<?= $value['button_text'] ?>">
					</fieldset>

					<fieldset class="form-group">
						<label for="formGroupExampleInput">Upload Images</label>
						<img src="<?= $value['slide_image'] ?>" width="40%" style="margin-bottom: 20px;">
						<input name="slide_image_old[]" type="hidden" class="form-control"
						value="<?= $value['slide_image'] ?>">

						<input name="slide_image[]" type="file" class="form-control">
					</fieldset>

				<?php endforeach ?>

					<fieldset class="form-group">
						<input type="submit" class="form-control btn btn-outline-info" value="Update">
					</fieldset>

				</form>
			</div>
		</div>
	</div>
</body>
</html>