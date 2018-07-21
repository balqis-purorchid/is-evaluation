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
            <div class="col-md-4">
                <form action='<?php echo base_url();?>create_bsc/generate_instrument' method='post'>
                    <h2>Buat Scorecard Baru</h2>
                    <h3>Pilih CSF dari sistem</h3>
                    <br />

                    <input type="hidden" name="id_sistem" value="<?php echo $id_sistem; ?>">
                    <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>">

                    <?php foreach ($csf as $row) { ?>
                        <input type="checkbox" name="csf[]" value="<?php echo $row->id_csf; ?>">
                        <label for="'<?php echo $row->id_csf; ?>'"><?php echo $row->teks_csf; ?></label>
                        <br />
                    <?php }
                    ?>

                    <input type='Submit' value='Generate Instrument' />
                
                </form>
            </div>
        </div>
    </div>
    

</body>
</html>