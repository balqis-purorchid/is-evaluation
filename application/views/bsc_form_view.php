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
        Anda telah berhasil membuat sebuah IT Balanced Scorecard untuk menilai sistem <?php echo $nama_sistem; ?> pada perspektif <?php echo $perspektif; ?>.

        Ini adalah akun yang akan digunakan untuk mengisi <a href="http://localhost/is-bsc">form</a> : <br />
        Username = <?php echo $username; ?> <br />
        Password = <?php echo $password; ?> <br />

        Anda dapat mengubah akun tersebut pada menu <a href="<?php echo base_url(); ?>/organisasi/responden">Akun Responden</a> <br />

        <table border="1">
            <?php foreach ($metrics as $row) { ?>
            <tr>
                <td width="100">
                    <?php echo $row['teks_metric']; ?>
                </td>
                <td>
                    <?php echo $row['bobot']; ?>
                </td>
            </tr>
            <?php } ?>
        </table>

        <br />
        <!-- <?php print_r($instrumen); ?> -->
        <!-- tampil form preview -->
        <table border="1">
            <?php foreach ($instrumen as $row) { ?>
            <tr>
                <td width="400">
                    <?php echo $row['teks_instrumen']; ?>
                </td>
                
                <?php 
                if($row['tipe_jawaban'] == "skala") { ?>
                    <td width="10%">
                        <?php echo $row['teks_skala1']; ?>
                    </td>
                    <td width="10%">
                        <?php echo $row['teks_skala2']; ?>
                    </td>
                    <td width="10%">
                        <?php echo $row['teks_skala3']; ?>
                    </td>
                    <td width="10%">
                        <?php echo $row['teks_skala4']; ?>
                    </td>
                    <td width="10%">
                        <?php echo $row['teks_skala5']; ?>
                    </td>
                    
                <?php } else if($row['tipe_jawaban'] == "yt") {?>
                    <td>
                        <?php echo "Ya"; ?>
                    </td>
                    <td>
                        <?php echo "Tidak"; ?>
                    </td>
                <?php } ?>
                    <td>
                        <?php echo $row['sasaran_strategi']; ?>
                    </td>
            </tr>
            <?php } ?>
        </table>

    </div>
    

</body>
</html>