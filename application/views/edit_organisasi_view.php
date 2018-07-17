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
		<?php if(! is_null($msg)) echo $msg;?>
		<br />
		Akun organisasi Anda.
		<form action="<?php echo base_url();?>organisasi/post_edit_org" method="post">
			<input type="hidden" name="id_org" value="<?php echo $akun_organisasi->id_org; ?>">
			<input type="text" name="nama_org" value="<?php echo $akun_organisasi->nama_org; ?>">
			<input type="text" name="username" value="<?php echo $akun_organisasi->username_org; ?>">
			<input type="text" name="password" value="<?php echo $akun_organisasi->password_org; ?>">
			<input type='Submit' class="btn btn-default" value='Simpan' />
		</form>
	</div>
	

</body>
</html>