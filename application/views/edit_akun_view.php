<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Edit Akun Responden</title>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/jQuery/custom.js"></script>
	<?php
		// print_r($nilai);
	?>

</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	
	<div class="main">
		<p>Akun untuk mengisi scorecard <?php echo $resp->nama_sistem; ?></p>
		<?php if(! is_null($msg)) echo $msg;?>
		<br />
		
		<form action="<?php echo base_url();?>organisasi/post_edit" method="post">
			<input type="hidden" name="id_resp" value="<?php echo $resp->id_responden; ?>">
			<table>
				<tr>
					<td height="50" width="100">
			            <label for='username_r'>Username</label>
            		</td>
					<td>
						<input type="text" name="username_r" value="<?php echo $resp->username_responden; ?>" required="required" />
					</td>
				</tr>
				<tr>
					<td height="50" width="100">
			            <label for='password_r'>Password</label>
            		</td>
					<td>
						<input type="password" name="password_r" value="<?php echo $resp->password_responden; ?>" required="required" />
					</td>
				</tr>
			</table>
			<input type='Submit' class="btn btn-default" value='Simpan' />
		</form>
		
	</div>
	

</body>
</html>