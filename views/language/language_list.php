<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
</head>
<body>
	<div class="container">
		<div class="btn-group btn-group-toggle btn-sm float-right" data-toggle="buttons">
			<a class="btn btn-sm btn-primary disabled text-white"><?php echo $this->lang->line('Select Language'); ?></a>
			<?php foreach ($get_all as $lang) { ?>
				<a class="btn btn-sm btn-primary" href="<?php echo base_url("language_manage/select_language/").$lang['lang_slug']; ?>"><?php echo $lang['lang_name']; ?></a>
			<?php } ?>
		</div>
		<?php
		$info  = $this->session->flashdata('info');
		$error = $this->session->flashdata('error');
		?>
		<div class="alert alert-<?php echo (isset($info) ? 'info' : ''); echo (isset($error) ? 'danger' : ''); ?> mt-4" role="alert">
			<?php echo $info . $error; ?>
		</div>
		<h2 class="my-4"><?php echo $this->lang->line('Add New Language'); ?></h2>
		<form method="POST" action="<?php echo base_url('language_manage/create_language'); ?>">
			<div class="form-row">
				<div class="form-group col">
					<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('Name of language to add'); ?>" name="name">
				</div>
				<div class="form-group col">
					<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('Folder name of the language to be added'); ?>" name="lang">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary mb-2 float-right"><?php echo $this->lang->line('Add New Language'); ?></button>
				</div>
			</div>
		</form>
		<h2 class="my-4"><?php echo $this->lang->line('List Languages'); ?></h2>
		<table id="lang_list" class="table table-striped table-bordered" style="width:100%;">
			<thead>
				<tr>
					<th class="w-50"><?php echo $this->lang->line('Language Name'); ?></th>
					<th class="w-25"><?php echo $this->lang->line('Language Folder Name'); ?></th>
					<th class="w-25 "><?php echo $this->lang->line('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($get_all as $value) { ?>
					<tr>
						<td style="text-transform: capitalize;"><?php echo $value['lang_name']; ?></td>
						<td><?php echo $value['lang_slug']; ?></td>
						<td><div class="float-right">
							<a class="btn btn-secondary"  href="<?php echo base_url('language_manage/edit_lang/').$value['lang_id']; ?>"><?php echo $this->lang->line('Edit'); ?></a>
							<a class="btn btn-dark text-white" href="<?php echo base_url('language_manage/del_lang/').$value['lang_id']; ?>"><?php echo $this->lang->line('Delete'); ?></a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php if ($missing_info['error']) { ?>
		<div class="alert alert-info" role="alert">
			<h5><u><?php echo $this->lang->line('Loss Information'); ?></u></h5>
			<?php echo $missing_info['miss_lang'] ?>
			<?php echo $missing_info['miss_dir'] ?>
		</div>
	<?php } ?>
	<h2 class="my-4"><?php echo $this->lang->line('Add New Language Key'); ?></h2>
	<form method="POST" action="<?php echo base_url('language_manage/add_key'); ?>">
		<div class="form-row">
			<div class="col">
				<input type="text" class="form-control" placeholder="<?php echo $this->lang->line('Enter Language Key'); ?>" name="key">
			</div>
			<div>
				<button class="btn btn-success float-right"><strong style="font-size: 16px">+</strong> <?php echo $this->lang->line('Add New Language Key'); ?></button>
			</div>
		</div>
	</form>
	<h2 class="my-4"><?php echo $this->lang->line('List Language Translations'); ?></h2>
	<table id="key_list" class="table table-striped table-bordered" style="width:100%;">
		<thead>
			<tr>
				<th class="w-50"><?php echo $this->lang->line('Language Key'); ?></th>
				<th class="w-25"><?php echo $this->lang->line('Translated Languages'); ?></th>
				<th class="w-25 "><?php echo $this->lang->line('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($get_all_key as $key_val) { ?>
				<tr>
					<td class="align-middle"><?php echo $key_val['lk_key']; ?></td>
					<td class="align-middle"><?php
					if ($key_val['lk_value'] === NULL) { ?>
						<span class="badge badge-warning"><?php echo $this->lang->line('No translation language has been added yet.'); ?>.</span>
					<?php }
					else
					{
						$translate_lang =  unserialize($key_val['lk_value']);
						foreach ($translate_lang as $tt => $val) { ?>
							<span class="badge badge-<?php if(empty($val)){ echo 'danger'; } else { echo 'info'; } ?>"><?php echo $tt; ?></span>
						<?php } }?>
					</td>
					<td class="align-middle"><div class="float-right">
						<a class="btn btn-secondary"  href="<?php echo base_url('language_manage/edit_key/').$key_val['lk_id']; ?>"><?php echo $this->lang->line('Edit'); ?></a>
						<a class="btn btn-dark text-white delete" href="<?php echo base_url('language_manage/del_key/').$key_val['lk_id']; ?>"><?php echo $this->lang->line('Delete'); ?></a>
					</div>
				</td>	
			</tr>
		<?php } ?>
	</tbody>
</table>
</div>
</body>
</html>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#lang_list').DataTable();
		$('#key_list').DataTable();
	} );
</script>
