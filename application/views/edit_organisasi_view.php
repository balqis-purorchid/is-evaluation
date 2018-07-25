<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/custom.js"></script>

	<title>Ubah akun: <?php echo $this->session->userdata('orgname');?></title>

</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	
	<div class="main">
		<p>Akun organisasi Anda.</p>
		<?php if(! is_null($msg)) echo $msg;?>
		<br />
		<form action="<?php echo base_url();?>organisasi/post_edit_org" method="post">
			<input type="hidden" name="id_org" value="<?php echo $akun_organisasi->id_org; ?>">
			<table>
				<tr>
					<td height="50" width="200">
			            <label for='nama_org'>Nama Organisasi</label>
            		</td>
					<td>
						<input type="text" name="nama_org" value="<?php echo $akun_organisasi->nama_org; ?>">
					</td>
				</tr>
				<tr>
					<td height="50" width="100">
			            <label for='username'>Username</label>
            		</td>
					<td>
						<input type="text" name="username" value="<?php echo $akun_organisasi->username_org; ?>">
					</td>
				</tr>
				<tr>
					<td height="50" width="100">
			            <label for='password'>Password</label>
            		</td>
					<td>
						<input type="password" name="password" value="<?php echo $akun_organisasi->password_org; ?>">
					</td>
				</tr>
			</table>
			
			<input type='Submit' class="btn btn-default" value='Simpan' />
		</form>
	</div>
	

</body>
</html>