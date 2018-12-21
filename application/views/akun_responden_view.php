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
		<p>Di bawah ini adalah tabel berisi aftar akun responden dari seluruh instrumen penilaian yang telah dibuat oleh <?php echo $this->session->userdata('orgname'); ?></p>
		<p>Tombol 'Edit' dapat digunakan untuk mengganti username dan password akun.</p>
		<p>Tombol 'Non-Aktifkan' dapat digunakan untuk menutup akun. <b>Perlu diketahui bahwa ketika sudah ditutup, akun tidak dapat digunakan untuk mengisi instrumen penilaian selama 6 bulan.</b> Setelah 6 bulan akun dapat diaktifkan kembali menggunakan tombol "Aktifkan" yang akan muncul secara otomatis.</p>
		<p>Grafik perkembangan dari putaran pertama dan seterusnya dapat dilihat pada menu Hasil Pengukuran dengan memilih sistem terkait.</p>
		<div class="panel panel-transparent">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Sistem</th>
								<th>Username</th>
								<th>Password</th>
								<th>Status</th>
								<th>Tanggal diaktifkan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter=1; foreach($responden as $row) {?>
							<tr>
								<td>
									<?php echo $counter; $counter++; ?>
								</td>
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
									<?php
									if($row['on_hold'] != 'false') {
										echo $row['tanggal_aktifasi'];
									} else if($row['on_hold'] == 'false') {
										echo "-";
									}
									?>
								</td>
								<td>
									<a href="<?php echo base_url(); ?>organisasi/editresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Edit</button></a>
									<?php if ($row['on_hold'] == 'aktifkan') {?>
										<a href="<?php echo base_url(); ?>organisasi/aktifkanresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Aktifkan</button></a>
									<?php } ?>
									<?php if ($row['on_hold'] == 'false') {?>
										<a href="<?php echo base_url(); ?>organisasi/nonaktifkanresp/<?php echo $row['id_responden']?>"><button type="button" class="btn btn-default">Non-Aktifkan</button></a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	

</body>
</html>