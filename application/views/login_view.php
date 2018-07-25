<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" class="full">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>
	<title>Welcome to IS Evaluation Tools</title>
</head>
<body background="http://localhost/is-evaluation/assets/img/conferencehall.jpg" style="margin-top: 50px;">
<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<h2 class="panel-title" style="color: white;">IS/IT Evaluation Tools</h2>
				</div>
				<div class="panel-body">
					<p><i>Tools</i> untuk mengevaluasi kinerja Departemen/Bagian Sistem/Teknologi Informasi dan produknya terhadap strategi bisnis yang telah direncanakan dalam sebuah organisasi</p>
					<p>Organisasi yang disarankan memakai <i>tools</i> ini adalah organisasi yang telah menggunakan Balanced Scorecard dalam perencanaan strategi bisnisnya, sehingga telah memiliki beberapa poin berikut :</p>
					<ul>
						<li>Objektif dari strategi yang dilaksanakan</li>
						<li>Ukuran <i>(measure)</i> dari objektif</li>
						<li><i>Critical Success Factor</i> dari aplikasi yang akan dievaluasi</li>
					</ul>
					<p>Evaluasi akan menggunakan <i>Information Technologi/System Balanced Scorecard</i> yang seluruh instrumennya disusun berdasarkan ukuran strategi dan <i>Critical Success Factor</i> yang dipilih organisasi.</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-transparent">
				<div class="panel-heading">
					<h2 class="panel-title" style="color: white;">User Login</h2>
				</div>
				<div class="panel-body">
					<div id='login_form'>
		        		<form action='<?php echo base_url();?>login/process' method='post'>

				            <?php if(! is_null($msg)) echo $msg;?>
				            <table>
				            	<tr>
				            		<td height="50" width="100">
							            <label for='username'>Username</label>
				            		</td>
				            		<td height="50">
				           				<input type='text' name='username' id='username' size='25' / required="required"><br />
				            		</td>
				            	</tr>
				            	<tr></tr>
				            	<tr>
				            		<td height="50" width="100">
							            <label for='password'>Password</label>
				            		</td>
				            		<td height="50">
							            <input type='password' name='password' id='password' size='25' required="required" /><br />                            
				            		</td>
				            	</tr>
				            </table>
				        
							<br/>
				            <input type='Submit' class="btn btn-default" value='Masuk' />
							<br/>
							<br/>
							<br/>
							<p><b>Belum punya akun?</b></p>
							<a href="<?php echo base_url();?>organisasi"><button type="button" class="btn btn-default">Daftar</button></a>
							<br/>
							<br/>
							<br/>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	

</body>
</html>