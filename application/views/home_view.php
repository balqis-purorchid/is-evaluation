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

	<title>Home: <?php echo $this->session->userdata('orgname');?></title>
</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	
	<div class="main">
		<?php if($bsc_aktif) { ?> 
		<div class="row">
			<?php foreach ($bsc_aktif as $row) {?>
			<div class="col-sm-3">
				<div class="panel panel-transparent">
					<div class="panel-body">
						<span class="glyphicon glyphicon-user pull-left" style="font-size: 50px;"></span>
						<p class="pull-right" style="font-size: 40px;"><?php echo $row->jumlah_resp; ?></p><br>
					</div>
					<a href="#"><div class="panel-footer" style="background-color: black;"><?php echo $row->nama_sistem;?> Putaran <?php echo $row->putaran; ?></div></a>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php if($all_bsc) { ?>
		<div class="panel panel-transparent">
			<div class="panel-heading">
				<h4 class="panel-title" style="color: white;">Daftar Scorecard yang telah dibuat</h4>
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<th>No.</th>
						<th>Perspektif</th>
						<th>Nama Sistem</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php $counter=1; foreach($all_bsc as $row) { ?>
						<tr>
                            <td>
                                <?php echo $counter; $counter++; ?>
                            </td>
							<td><?php echo $row->perspektif; ?></td>
							<td><?php echo $row->nama_sistem; ?></td>
							<td><a href="<?php echo base_url(); ?>home/loadbsc/<?php echo $row->id_bsc?>"><button type="button" class="btn btn-default">Lihat Instrumen</button></a></td>
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
				<p>Anda belum memiliki ITBSC-CSF apapun. Silakan buat ITBSC-CSF untuk mengevaluasi Sistem Informasi Anda pada menu "Buat Scorecard" di sidebar.</p>
			</div>
			
		<?php } ?>

</body>
</html>