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
    <?php $this->load->view('template/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <!-- <div class="col-md-4"> -->
                <!-- <div id='login_form'> -->
                    <form action='<?php echo base_url();?>create_bsc/finishing_bsc' method='post'>
                        <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>">
                        <input type="hidden" name="username" value="<?php echo $username; ?>">
                        <input type="hidden" name="password" value="<?php echo $password; ?>">
                        <input type="hidden" name="perspektif" value="<?php echo $perspektif; ?>">
                        <input type="hidden" name="id_sistem" value="<?php echo $id_sistem; ?>">
                        <input type="hidden" name="nama_sistem" value="<?php echo $nama_sistem; ?>">
                        <!-- <input type="hidden" name="instrumen" value="<?php echo $instrumen; ?>"> -->

                        <h2>Buat Scorecard Baru</h2>
                        <h3>Isi sasaran strategi yang akan dijadikan bahan penilaian untuk masing-masing instrumen penilaian</h3>
                        <br />
                        <table border="1">
                            <th>Instrumen</th>
                            <th>Sasaran</th>
                        <?php foreach ($instrumen as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $row->teks_instrumen; ?>
                                </td>
                                <td>
                                    <input type="number" name="sasaran_strategi[<?php echo $row->id_instrumen; ?>]" max="100" min="0">
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                        <br />
                        

                        <input type='Submit' value='Generate BSC' />
                    
                    </form>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    

</body>
</html>