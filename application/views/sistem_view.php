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
            <h3>Buat Scorecard Baru</h3>
            <br />
            <p>Pilih sistem yang akan dievaluasi</p>
            <form action='<?php echo base_url();?>create_bsc/generate_csf' method='post'>
                <!-- <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>"> -->
                <?php foreach ($sistem as $row) { ?>
                    <input type="radio" name="sistem" value="<?php echo $row->id_sistem; ?>" checked="checked">
                    <label for="'<?php echo $row->id_sistem; ?>'"><?php echo $row->nama_sistem; ?></label>
                    <br />
                <?php } ?>
                <hr>
                    <br />
                <p>Pilih ukuran yang akan digunakan</p>
                <p>Silakan pilih kategori dari ukuran yang diinginkan. Pada 1 kategori terdapat beberapa ukuran seperti yang dapat dilihat pada tabel di bawah. Deskripsi akan membantu Anda dalam memilih kategori ukuran yang dirasa perlu untuk diukur.</p>
                <table class="table">
                    <thead>
                        <th>Kategori</th>
                        <th>Ukuran (Measures)</th>
                        <th>Deskripsi</th>
                    </thead>
                    <tbody>
                        <?php
                            $tag = $metrics['0']->tag;
                            $count = 0;
                            foreach ($metrics as $row) { 
                        ?>
                        <tr>
                            <td>
                                <?php if($count ==0) { ?>
                                    <input type="checkbox" name="tag[]" value="<?php echo $tag; ?>">
                                    <?php echo $tag; $count++; ?>
                                <?php } if($row->tag != $tag && $count!=0) { ?>
                                    <?php $tag = $row->tag; ?>
                                    <input type="checkbox" name="tag[]" value="<?php echo $tag; ?>">
                                    <?php echo $tag; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $row->teks_metric; ?>
                            </td>
                            <td>
                                <?php echo $row->deskripsi; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br />
                
                <input type='Submit' class="btn btn-default pull-right" value='Lanjut pilih CSF' />
            
            </form>
        </div>
    </div>
    

</body>
</html>