<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home: <?php echo $this->session->userdata('orgname');?></title>
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
				<td>
					<a href="<?php echo base_url(); ?>organisasi/editresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Edit</button></a>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>
	

</body>
</html>