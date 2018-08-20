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
	<!-- <?php $this->load->view('template/navbar.php'); ?> -->
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
					<a href="#"><div class="panel-footer" style="background-color: black;"><?php echo $row->nama_sistem;?></div></a>
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
						<th>Perspektif</th>
						<th>Nama Sistem</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($all_bsc as $row) { ?>
						<tr>
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

		<div class="row">
			<div class="col-sm-3">
				<a href="<?php echo base_url();?>home/business"><button type="button" class="btn btn-default">Business Value</button></a>
			</div>
		</div>
		<div class="row">
			<canvas id="canvas" width="1000" height="200" border="1"></canvas>
			<!--Load chart js-->
   			<script type="text/javascript" src="http://localhost/is-evaluation/assets/Chartjs/dist/chart.min.js"></script>
		    <!-- <script>
		    	var lineChartData = {
		    		// labels : ["Business Value", "Internal Process", "User Orientation", "Future Orientation"],
		    		datasets : [
		    			<?php 
		    				$i=0;
		    				$count = count($putaran);
		    				for($i=0; $i<=$count; $i++) {?>
		    			{
		    				label: <?php echo $putaran[i];?>,
		    				orderColor: window.chartColors.red,
							backgroundColor: window.chartColors.red,
							fill: false,
		    				data : <?php echo json_encode($nilai_total)?>
		    			}
		    				<?php }?>
		    		]
		    	}
		    	var ctx = document.getElementById("canvas").getContext('2d');
		    	var myLine = new Chart(ctx, {
		    		type: "line",
		            data: lineChartData, 
		        });       
		    </script> -->
		</div>
	</div>
	

</body>
</html>