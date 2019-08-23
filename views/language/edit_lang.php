<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
</head>
<body>
	<div class="container">
		<div style="height: 350px"></div>
		<?php
		$info  = $this->session->flashdata('info');
		$error = $this->session->flashdata('error');
		?>
		<div class="alert alert-<?php echo (isset($info) ? 'info' : ''); echo (isset($error) ? 'danger' : ''); ?> mt-4" role="alert">
			<?php echo $info . $error; ?>
		</div>
		<h2><?php echo $this->lang->line('Update Language Information'); ?></h2>
		<form method="POST" action="<?php echo base_url('language_manage/edit_lang_done/'.$lang_id); ?>">
			<div class="row">
				<div class="form-group col-6">
					<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('Name of language to add'); ?>" name="name" value="<?php echo $lang_name; ?>">
				</div>
				<div class="form-group col-6">
					<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('Folder name of the language to be added'); ?>" name="slug" value="<?php echo $lang_slug; ?>">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary mb-2 float-right"><?php echo $this->lang->line('Update Current Language'); ?></button>
				<a class="float-right mr-2 p-3" href="<?php echo base_url() ?>">< <?php echo $this->lang->line('Turn Back'); ?></a>
			</div>
		</form>
	</div>
</body>
</html>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>