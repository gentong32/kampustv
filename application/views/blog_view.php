<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Autocomplete</title>
	<link rel="stylesheet" href="<?php echo base_url() . 'css/bootstrap.css' ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'css/jquery-ui.css' ?>">
</head>
<body>
<div class="container">
	<div class="row">
		<h2>Autocomplete Codeigniter</h2>
	</div>
	<div class="row">
		<form>
			<div class="form-group">
				<label>Title</label>
				<input type="text" name="title" class="form-control" id="title" placeholder="Title"
					   style="width:500px;height:50px">
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea name="description" id="description" class="form-control" placeholder="Description"
						  style="width:500px;"></textarea>
			</div>
		</form>
	</div>
</div>

<!--<script src="--><?php //echo base_url() . 'js/jquery-3.4.1.js' ?><!--" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url() . 'js/bootstrap.js' ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'js/jquery-ui.js' ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#title').autocomplete({
			source: '<?php echo (site_url() . "vod/get_autocomplete");?>',
			minLength: 1,
			select: function (event, ui) {
				$('#title').val(ui.item.value);
				//$('#description').val(ui.item.deskripsi);
			}
		});

	});
</script>

</body>
</html>
