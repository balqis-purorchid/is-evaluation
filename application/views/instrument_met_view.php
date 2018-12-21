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

    <title>New Scorecard</title>
</head>
<body>
    <!-- javascript buat ngecek jumlah bobot tiap perspektif udah 100 -->
    <script>
        function myFunction() {
            // var group = {};
            var sum0 = 0, sum1 = 0, sum2 = 0, sum3 = 0;
            var elements = document.forms.metinsForm.getElementsByTagName("input");
            for(var i = 0; i < elements.length; i++)
            {
                // console.log(elements[i]);
                var groupName = elements[i].id;
                if(groupName == 'bobot0') {
                    sum0 = sum0 + parseInt(elements[i].value);
                } else if(groupName == 'bobot1') {
                    sum1 = sum1 + parseInt(elements[i].value);
                } else if(groupName == 'bobot2') {
                    sum2 = sum2 + parseInt(elements[i].value);
                } else if(groupName =='bobot3') {
                    sum3 = sum3 + parseInt(elements[i].value);
                }
            }

            if(sum0!=100 || sum1!=100 || sum2!=100 || sum3!=100) {
                alert("Bobot pada salah satu perspektif tidak 100");
                return false;
            } 
            else if(sum0==100 && sum1==100 && sum2==100 && sum3==100) {
                return true;
            }
            
        }
    </script>

    <?php $this->load->view('template/navbar.php'); ?>
    <div class="container">
        <!-- <?php print_r($metrics); ?> -->
        <div class="row">
            <form action='<?php echo base_url();?>create_bsc/finishing_bsc' id="metinsForm" method='post'>
                <!-- <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>"> -->
                <h3>Buat Scorecard Baru</h2>
                <p>Isi bobot dari setiap ukuran yang akan dijadikan bahan penilaian</p>
                <!-- <br /> -->
                <table class="table">
                    <thead>
                        <th>No.</th>
                        <th>Ukuran (Measure)</th>
                        <th>Bobot</th>
                    </thead>
                    <tbody>
                        <?php 
                            $pers = $metrics[0]->perspektif;
                            $count = 0;
                            $mark = 0;
                            $counter = 1;
                        ?>
                        <tr><td colspan="2"><b>Tentukan bobot ukuran dari perspektif <?php echo $pers; ?></b></td></tr>
                        <?php
                            foreach ($metrics as $row) { 
                            // cek kalo perspektifnya sama, name nya sama
                                if($row->perspektif != $pers) {
                                    $pers = $row->perspektif;
                                    $count++; ?>
                                    <tr>
                                        <td colspan="2"><b>Tentukan bobot ukuran dari perspektif <?php echo $pers; ?></b></td>
                                    </tr>
                                <?php }
                                if($pers == $perspektif_c && $mark==0) {
                                    foreach ($csf as $key) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $counter; $counter++; ?>
                                            </td>
                                            <td>
                                                <?php echo $key->teks_csf; ?>
                                            </td>
                                            <td>
                                                <input type="number" name="bobotcsf[<?php echo $key->id_csf; ?>]" id="bobot<?php echo $count;?>" max="100" min="0" required="required">
                                            </td>
                                        </tr>
                                    <?php }
                                    $mark=1;
                                } ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; $counter++; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_metric; ?>
                                    </td>
                                    <td>
                                        <input type="number" name="bobot<?php echo $count;?>[<?php echo $row->id_metric; ?>]" id="bobot<?php echo $count;?>" max="100" min="0" required="required">
                                    </td>
                                </tr>
                                
                            <?php } ?>
                    </tbody>
                </table>
                <br />

                <p>Isi sasaran strategi yang akan dijadikan bahan penilaian untuk masing-masing instrumen penilaian</p>
                <br />
                <table class="table">
                    <thead>
                        <th>No.</th>
                        <th>Instrumen</th>
                        <th>Sasaran</th>
                    </thead>
                    <tbody>
                        <?php $counter=1; foreach ($instrumen as $row) { ?>
                        <tr>
                            <td>
                                <?php echo $counter; $counter++; ?>
                            </td>
                            <td>
                                <?php echo $row->teks_instrumen; ?>
                            </td>
                            <td>
                                <input type="number" name="sasaran_strategi[<?php echo $row->id_instrumen; ?>]" max="100" min="10" required="required">
                            </td>
                        </tr>
                        <?php } ?>
                        <?php foreach ($instrumencsf as $row) { ?>
                        <tr>
                            <td>
                                <?php echo $counter; $counter++; ?>
                            </td>
                            <td>
                                <?php echo $row->teks_instrumen; ?>
                            </td>
                            <td>
                                <input type="number" name="sasaran_strategi[<?php echo $row->id_instrumen; ?>]" max="100" min="10" required="required">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <input type='Submit' onclick="return myFunction();" class="btn btn-default pull-right" value='Generate Evaluation Scorecard' />
            
            </form>
        </div>
    </div>
    

</body>
</html>