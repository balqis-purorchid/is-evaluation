<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<title>Welcome to IS Evaluation Tools</title>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div id='login_form'>
        		<form action='<?php echo base_url();?>login/process' method='post'>
					<h2>User Login</h2>
		            <br />

		            <?php if(! is_null($msg)) echo $msg;?>
		            <table>
		            	<tr>
		            		<td height="50" width="100">
					            <label for='username'>Username</label>
		            		</td>
		            		<td height="50">
		           				<input type='text' name='username' id='username' size='25' /><br />
		            		</td>
		            	</tr>
		            	<tr></tr>
		            	<tr>
		            		<td height="50" width="100">
					            <label for='password'>Password</label>
		            		</td>
		            		<td height="50">
					            <input type='password' name='password' id='password' size='25' /><br />                            
		            		</td>
		            	</tr>
		            </table>
		        
		            <input type='Submit' class="btn btn-default" value='Masuk' />
					
					<a href="<?php echo base_url();?>organisasi"><button type="button" class="btn btn-default">Daftar</button></a>
					
				</form>
			</div>
		</div>
	</div>
</div>
	

</body>
</html>