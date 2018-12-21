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

	<title>Hasil Sistem</title>
</head>
<body>  
	<?php $this->load->view('template/sidebar.php'); ?>
	<!--Load chart js-->
	<script type="text/javascript" src="http://localhost/is-evaluation/assets/Chartjs/dist/chart.min.js"></script>
   
   <div class="main">
      <div class="row">
         <div class="col-sm-8">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse1"> Grafik Nilai Tiap Putaran</a></h2>
               </div>
               <div id="collapse1" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <canvas id="myChart" width="700" height="300" border="0"></canvas>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse2">Grafik Responden Tiap Putaran</a></h2>
               </div>
               <div id="collapse2" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <canvas id="resChart" width="400" height="200" border="0"></canvas>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse6">Daftar Tingkat Tiap Putaran</a></h2>
               </div>
               <div id="collapse6" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <table class="table">
                        <thead>
                           <th>Putaran</th>
                           <th>Nilai Akhir</th>
                           <th>Tingkat</th>
                           <th>Keterangan</th>
                        </thead>
                        <tbody>
                           <?php foreach ($arr_nilai as $row) { ?>
                              <tr>
                                 <td><?php echo $row->putaran; ?></td>
                                 <td><?php echo $row->total_nilai; ?></td>
                                 <td><?php echo $row->tingkat; ?></td>
                                 <td><?php echo $row->keterangan; ?></td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse3">Grafik Perbandingan Sasaran dan Kondisi Aktual Putaran Terakhir</a></h2>
               </div>
               <div id="collapse3" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <canvas id="insChart" width="700" height="300" border="0"></canvas>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse4">Daftar Nilai Tiap Instrumen Penilaian - Putaran Terakhir</a></h2>
               </div>
               <div id="collapse4" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <table class="table">
                        <thead>
                           <th>No.</th>
                           <th width="65%">Instrumen</th>
                           <th>Kondisi Aktual</th>
                           <th>Sasaran</th>
                           <th>Pencapaian</th>
                        </thead>
                        <tbody>
                           <?php 
                           $counter=1; 
                           $min = min(array_column($arr_instrumen, 'kondisi_aktual'));
                           $max = max(array_column($arr_instrumen, 'kondisi_aktual'));
                           foreach ($arr_instrumen as $row) { 
                           ?>
                              <?php if ($row->kondisi_aktual == $min) { ?>
                                 <tr style="background: #d93030; color: black;">
                              <?php } else if ($row->kondisi_aktual == $max) { ?>
                                 <tr style="background: #10e02f; color: black;">
                              <?php } else { ?>
                                 <tr>
                              <?php } ?>
                                    <td><?php echo $counter; $counter++; ?></td>
                                    <td><?php echo $row->teks_instrumen; ?></td>
                                    <td><?php echo $row->kondisi_aktual; ?>%</td>
                                    <td><?php echo $row->sasaran_strategi; ?>%</td>
                                    <td><?php echo $row->pencapaian; ?>%</td>
                                 </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-transparent">
               <div class="panel-heading">
                  <h2 class="panel-title" style="color: white;"><a data-toggle="collapse" href="#collapse5">Daftar Nilai Ukuran (IT BSC dan CSF) - Putaran Terakhir</a></h2>
               </div>
               <div id="collapse5" class="panel-collapse collapse in">
                  <div class="panel-body">
                     <table class="table">
                        <thead>
                           <th>No.</th>
                           <th width="65%">Ukuran IT BSC / CSF</th>
                           <th>Bobot</th>
                           <th>Hasil Ukuran</th>
                           <th>Hasil Tujuan</th>
                        </thead>
                        <tbody>
                           <?php 
                           $counter=1; 
                           $min = min(array_column($arr_met, 'hasil_ukuran'));
                           $max = max(array_column($arr_met, 'hasil_ukuran'));
                           foreach ($arr_met as $row) { 
                           ?>
                              <?php if ($row->hasil_ukuran == $min) { ?>
                                 <tr style="background: #d93030; color: black;">
                              <?php } else if ($row->hasil_ukuran == $max) { ?>
                                 <tr style="background: #10e02f; color: black;">
                              <?php } else { ?>
                                 <tr>
                              <?php } ?>
                                    <td><?php echo $counter; $counter++; ?></td>
                                       <?php if(property_exists($row, 'id_csf')) { ?>
                                       <td><?php echo $row->teks_csf; ?></td>
                                       <?php } else { ?>
                                       <td><?php echo $row->teks_metric; ?></td>
                                       <?php } ?>
                                    <td><?php echo $row->bobot; ?></td>
                                    <td><?php echo $row->hasil_ukuran; ?></td>
                                    <td><?php echo $row->hasil_tujuan; ?></td>
                                 </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>

	<script>
      var ctx = document.getElementById("myChart").getContext('2d');
      var ctx2 = document.getElementById("resChart").getContext('2d');
      var ctx3 = document.getElementById("insChart").getContext('2d');
      var lineChartData = {
         labels : [ <?php foreach ($arr_nilai as $row) { ?>
            "<?php echo 'Putaran '.$row->putaran; ?>",
            <?php } ?>
         ],
         datasets : [
            {
               label: "Business Value",
               backgroundColor: 'rgba(60,141,188,0.9)',
               borderColor: 'rgba(60,141,188,0.9)',
               data: [ <?php foreach($arr_nilai as $row) { ?>
                  <?php echo $row->nilai_bv; ?>,
               <?php } ?>
               ],
               fill: false
            },
            {
               label: "Internal Process",
               backgroundColor: 'rgba(247, 8, 68, 1)',
               borderColor: 'rgba(247, 8, 68, 1)',
               data: [ <?php foreach($arr_nilai as $row) { ?>
                  <?php echo $row->nilai_ip; ?>,
               <?php } ?>
               ],
               fill: false
            },
            {
               label: "User Orientation",
               backgroundColor: 'rgba(8, 247, 88, 1)',
               borderColor: 'rgba(8, 247, 88, 1)',
               data: [ <?php foreach($arr_nilai as $row) { ?>
                  <?php echo $row->nilai_uo; ?>,
               <?php } ?>
               ],
               fill: false
            },
            {
               label: "Future Readiness",
               backgroundColor: 'rgba(247, 92, 8, 1)',
               borderColor: 'rgba(247, 92, 8, 1)',
               data: [ <?php foreach($arr_nilai as $row) { ?>
                  <?php echo $row->nilai_fr; ?>,
               <?php } ?>
               ],
               fill: false
            }
         ]
      };
      var myChart = new Chart(ctx, {
         type: 'line',
         data: lineChartData
      });
      var resChartData = {
         labels : [ <?php foreach ($arr_nilai as $row) { ?>
            "<?php echo 'Putaran '.$row->putaran; ?>",
            <?php } ?>
         ],
         datasets : [
            {
               label: "IT",
               backgroundColor: 'rgba(247, 8, 68, 1)',
               borderColor: 'rgba(247, 8, 68, 1)',
               data: [ <?php foreach ($arr_nilai as $row) { ?>
                  <?php echo $row->jumlah_IT; ?>,
               <?php } ?>
               ],
               fill: false
            },
            {
               label: "Non-IT",
               backgroundColor: 'rgba(33, 63, 196, 1)',
               borderColor: 'rgba(33, 63, 196, 1)',
               data: [ <?php foreach ($arr_nilai as $row) { ?>
                  <?php echo $row->jumlah_nonIT; ?>,
               <?php } ?>
               ],
               fill: false
            }
         ]
      };
      var resChart = new Chart(ctx2, {
         type: 'bar',
         data: resChartData
      });
      var insChartData = {
         labels : [ <?php $counter = 1; foreach ($arr_instrumen as $row) { ?>
            "<?php echo $counter; ?>",
            <?php $counter++; } ?>
         ],
         datasets : [
            {
               label: "Kondisi Aktual",
               backgroundColor: 'rgba(60,141,188,0.9)',
               borderColor: 'rgba(60,141,188,0.9)',
               data: [ <?php foreach($arr_instrumen as $row) { ?>
                  <?php echo $row->kondisi_aktual; ?>,
               <?php } ?>
               ],
               fill: false
            },
            {
               label: "Sasaran",
               backgroundColor: 'rgba(247, 8, 68, 1)',
               borderColor: 'rgba(247, 8, 68, 1)',
               data: [ <?php foreach($arr_instrumen as $row) { ?>
                  <?php echo $row->sasaran_strategi; ?>,
               <?php } ?>
               ],
               fill: false
            }
         ]
      };
      var insChart = new Chart(ctx3, {
         type: 'bar',
         data: insChartData
      });
   </script>

</body>
</html>