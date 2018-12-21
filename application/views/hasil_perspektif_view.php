<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>
	<script src="http://localhost/is-evaluation/assets/jQuery/custom.js"></script>

	<title>Hasil Perspektif <?php echo $perspektif;?></title>
</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	
	<div class="main">
		
		<?php if($bsc) { ?>
		<div class="panel panel-transparent">
			<div class="panel-heading">
				<h4 class="panel-title" style="color: white;">Daftar Scorecard Perspektif <?php echo $bsc[0]->perspektif;?></h4>
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<th>No.</th>
						<th>Nama Sistem</th>
						<!-- <th>Jumlah Responden</th> -->
						<th>Action</th>
					</thead>
					<tbody>
						<?php $counter=1; foreach($bsc as $row) { ?>
						<tr>
                            <td>
                                <?php echo $counter; $counter++; ?>
                            </td>
							<td><?php echo $row->nama_sistem; ?></td>
							<!-- <td><?php echo $row->jumlah_resp; ?></td> -->
							<!-- kalau scorecard dah ga aktif baru bisa lihat hasil -->
							<?php if($row->on_hold == "true" or $row->on_hold == "aktifkan") { ?>
								<td><a href="<?php echo base_url(); ?>hasil/cek_hasil_sistem/<?php echo $row->id_bsc?>"><button type="button" class="btn btn-default">Lihat Hasil</button></a></td>
							<?php } else if($row->on_hold == "false") { ?>
								<td>Masih aktif</td>
							<?php } ?>
						</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			
		</div>
			
		<?php } else { ?>
			<div>
				<p>Anda belum memiliki ITBSC-CSF apapun pada perspektif ini. Silakan buat ITBSC-CSF untuk mengevaluasi Sistem Informasi Anda pada menu "Buat Scorecard" di sidebar.</p>
			</div>
			
		<?php } ?>

</body>
</html>