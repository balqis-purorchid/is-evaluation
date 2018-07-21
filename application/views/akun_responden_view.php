<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Responden: <?php echo $this->session->userdata('orgname');?></title>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
	<?php
		// print_r($nilai);
	?>

</head>
<body>  
	<?php $this->load->view('template/navbar.php'); ?>
	
	<div class="container">
		<table border="1">
			<th>Username</th>
			<th>Password</th>
			<th>Sistem</th>
			<th>Status</th>
			<th>Action</th>
			<?php foreach($responden as $row) {?>
			<tr>
				<td width="100" height="25">
					<?php echo $row['username_responden']; ?>
				</td>
				<td width="100">
					<?php echo $row['password_responden']; ?>
				</td>
				<td width="500">
					<?php echo $row['nama_sistem']; ?>
				</td>
				<td width="100">
					<?php
					if($row['on_hold'] == 'true') {
						echo "On-Hold";
					} else {
						echo "Aktif";
					}
					?>
				</td>
				<td align="center">
					<a href="<?php echo base_url(); ?>organisasi/editresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Edit</button></a>
					<?php if ($row['on_hold'] == 'aktifkan') {?>
						<a href="<?php echo base_url(); ?>organisasi/aktifkanresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Aktifkan</button></a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
	

</body>
</html>