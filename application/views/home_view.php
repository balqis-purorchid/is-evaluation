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