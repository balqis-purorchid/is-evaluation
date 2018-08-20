<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/jQuery/custom.js"></script>
	<title>Akun Responden</title>
</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	
	<div class="main">
		<h4 style="font-weight: bold;">Daftar Akun Responden</h4>
		<p>Daftar akun responden dari seluruh <i>scorecard</i> yang telah dibuat oleh <?php echo $this->session->userdata('orgname'); ?></p>
		<p>Tiga hari setelah <i>scorecard</i> dibuat, akun responden yang dapat digunakan untuk mengisinya akan <i>expired</i> atau berada dalam status <i>on-hold</i>. Anda dapat mengaktifkan akun tersebut setelah 6 bulan (tombol Aktfikan akan muncul otomatis), untuk mengisi <i>scorecard</i> kembali. Grafik perkembangan dari putaran pertama dan seterusnya dapat dilihat pada menu Grafik Nilai.</p>
		<p>Menu 'Edit' dapat digunakan untuk mengganti username dan password akun.</p>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Sistem</th>
						<th>Username</th>
						<th>Password</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($responden as $row) {?>
					<tr>
						<td>
							<?php echo $row['nama_sistem']; ?>
						</td>
						<td>
							<?php echo $row['username_responden']; ?>
						</td>
						<td>
							<?php echo $row['password_responden']; ?>
						</td>
						<td>
							<?php
							if($row['on_hold'] == 'true') {
								echo "On-Hold";
							} else if($row['on_hold'] == 'false') {
								echo "Aktif";
							} else {
								echo "Menunggu diaktifkan";
							}
							?>
						</td>
						<td>
							<a href="<?php echo base_url(); ?>organisasi/editresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Edit</button></a>
							<?php if ($row['on_hold'] == 'aktifkan') {?>
								<a href="<?php echo base_url(); ?>organisasi/aktifkanresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Aktifkan</button></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	

</body>
</html>