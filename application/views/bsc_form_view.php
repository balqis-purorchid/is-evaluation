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

    <title>New Scorecard</title>
</head>
<body>
    <?php $this->load->view('template/post-navbar.php'); ?>

    <div class="container">
        <div class="row">
            

            <div class="col-sm-8">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <h2 class="panel-title">Detail Ukuran (Measure)</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <th>No.</th>
                                <th>Ukuran (Measure) yang digunakan</th>
                                <th>Bobot</th>
                            </thead>
                            <tbody>
                                <?php $counter = 1; foreach ($metrics as $row) { ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; $counter++; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_metric; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->bobot; ?>%
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php foreach ($csf as $row) { ?>
                                <tr>
                                    <td>
                                        <?php echo $counter; $counter++; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_csf; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->bobot; ?>%
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <h2 class="panel-title">Akun responden</h2>
                    </div>
                    <div class="panel-body">
                        <p>Anda telah berhasil membuat sebuah instrumen penilaian untuk mengukur <?php echo $nama_sistem; ?> pada perspektif <?php echo $perspektif; ?>.</p>

                        <p>Ini adalah akun yang akan digunakan untuk mengisi instrumen penilaian : </p>

                        <table>
                            <tr>
                                <td width="100">
                                    Username
                                </td>
                                <td width="10">
                                    :
                                </td>
                                <td>
                                    <?php echo $username; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="100">
                                    Password
                                </td>
                                <td width="10">
                                    :
                                </td>
                                <td>
                                    <?php echo $password; ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <p>Anda dapat mengubah akun tersebut pada menu <a href="<?php echo base_url(); ?>/organisasi/responden">Akun Responden</a> <br /></p>

                        <a href="<?php echo base_url();?>home"><button class="btn btn-default pull-right">Kembali ke Beranda</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <h2 class="panel-title">Detail Pertanyaan</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <th>No.</th>
                                <th>Pertanyaan</th>
                                <th colspan="5">Kriteria Jawaban</th>
                                <th>Sasaran Strategi</th>
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
                                        <?php echo $row->teks_skala1; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_skala2; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_skala3; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_skala4; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->teks_skala5; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->sasaran_strategi; ?>%
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>