<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Aktifkan Akun Responden</title>
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
		<?php echo $keterangan; ?>
		<?php if(! is_null($msg)) echo $msg;?>
		<br />
		Akun untuk mengisi scorecard <?php echo $resp->nama_sistem; ?>
		<form action="<?php echo base_url();?>organisasi/aktifkan_akun" method="post">
			<input type="hidden" name="id_resp" value="<?php echo $resp->id_responden; ?>">
			<input type="text" name="username_r" value="<?php echo $resp->username_responden; ?>" required="required" />
			<input type="text" name="password_r" value="<?php echo $resp->password_responden; ?>" required="required" />
			<input type='Submit' class="btn btn-default" value='Simpan' />
		</form>
	</div>
	

</body>
</html>