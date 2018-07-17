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
                <div id='login_form'>
                    <form action='<?php echo base_url();?>create_bsc/generate_system' method='post'>
                        <h2>Buat Scorecard Baru</h2>
                        <h3>Pilih Perspektif dari Sistem yang akan dinilai</h3>
                        <br />
                        <input type="radio" name="perspective" value="Business Value" checked="checked">
                        <label for="Business Value">Business Value</label>
                        <br />
                        <input type="radio" name="perspective" value="User Orientation">
                        <label for="User Orientation">User Orientation</label>
                        <br />
                        <input type="radio" name="perspective" value="Internal Process">
                        <label for="Internal Process">Internal Process</label>
                        <br />
                        <input type="radio" name="perspective" value="Future Orientation">
                        <label for="Future Orientation">Future Orientation</label>
                        <br />
                        <input type='Submit' value='Choose System' />
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</body>
</html>