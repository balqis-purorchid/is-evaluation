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
        <!-- <?php print_r($metrics); ?> -->
        <div class="row">
            <form action='<?php echo base_url();?>create_bsc/finishing_bsc' method='post'>
                <!-- <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>"> -->
                <h3>Buat Scorecard Baru</h2>
                <p>Isi sasaran strategi yang akan dijadikan bahan penilaian untuk masing-masing instrumen penilaian</p>
                <!-- <br /> -->
                <table class="table">
                    <thead>
                        <th>Ukuran (Measure)</th>
                        <th>Bobot</th>
                    </thead>
                    <tbody>
                        <?php foreach ($metrics as $row) { ?>
                        <tr>
                            <td>
                                <?php echo $row->teks_metric; ?>
                            </td>
                            <td>
                                <input type="number" name="bobot[<?php echo $row->id_metric; ?>]" max="100" min="0">
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
                        <th>Instrumen</th>
                        <th>Sasaran</th>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
                
                <input type='Submit' class="btn btn-default pull-right" value='Generate Evaluation Scorecard' />
            
            </form>
        </div>
    </div>
    

</body>
</html>