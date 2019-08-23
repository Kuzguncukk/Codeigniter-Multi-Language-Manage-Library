<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
</head>
<body>
	<div class="container">
		<div style="margin-top:200px"></div>
		<?php
		$info  = $this->session->flashdata('info');
		$error = $this->session->flashdata('error');
		?>
		<div class="alert alert-<?php echo (isset($info) ? 'info' : ''); echo (isset($error) ? 'danger' : ''); ?> mt-4" role="alert">
			<?php echo $info . $error; ?>
		</div>

		<h2 class="pt-5"><?php echo sprintf($this->lang->line('Key translations for %s'), '"<span class="text-info">'.$key.'</span>"'); ?></h2>
		<table class="table table-striped table-bordered" style="width:100%;">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('Translated Language'); ?></th>
					<th><?php echo $this->lang->line('Translation'); ?></th>
					<th><?php echo $this->lang->line('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>

				<?php
				if ($translate == NULL)
				{
					echo $this->lang->line('No translation added'); 
				} 
				else
				{
					foreach ($translate as $value => $key) { ?>
						<form method="POST" action="<?php echo base_url("language_manage/edit_key_value/$lk_id/$value") ?>">
							<tr>
								<td class="align-middle"><input type="text" value="<?php echo $value ?>" class="form-control" disabled></td>
								<td class="align-middle">
									<input type="text" name="translate" value="<?php echo $key; ?>" class="form-control">
								</td>
								<td>
									<div class="float-right">
										<button class="btn btn-warning" type="submit"><?php echo $this->lang->line('Update'); ?></button>
									</div>
								</td>
							</tr>
						</form>
					<?php }} ?>
				</tbody>
			</table>
		</table>
		<a class="float-right mr-2" href="<?php echo base_url() ?>">< <?php echo $this->lang->line('Turn Back'); ?></a>
	</div>
</body>
</html>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>