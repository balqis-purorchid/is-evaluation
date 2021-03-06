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
    <script type="text/javascript">
        function checkVal() {
            checked = $("input[type=checkbox]:checked").length;

            if(!checked) {
                alert("Harap pilih setidaknya 1 CSF");
                return false;
            } else {
                return true;
            }
        }
    </script>
    <?php $this->load->view('template/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <h3>Buat Scorecard Baru</h3>
            <br />
            <p>Pilih CSF dari sistem</p>
            <form action='<?php echo base_url();?>create_bsc/generate_instrument' method='post'>

                <!-- <input type="hidden" name="id_sistem" value="<?php echo $id_sistem; ?>"> -->
                <!-- <input type="hidden" name="id_bsc" value="<?php echo $id_bsc; ?>"> -->

                <?php foreach ($csf as $row) { ?>
                    <input type="checkbox" name="csf[]" value="<?php echo $row->id_csf; ?>">
                    <label for="'<?php echo $row->id_csf; ?>'"><?php echo $row->teks_csf; ?></label>
                    <br />
                <?php }
                ?>

                <input type='Submit' onclick="return checkVal();" class="btn btn-default" value='Lanjut ke instrumen' />
            
            </form>
        </div>
    </div>
    

</body>
</html>