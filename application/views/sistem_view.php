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
                    <form action='<?php echo base_url();?>create_bsc/generate_csf/<?php echo $id_bsc; ?>' method='post'>
                        <h2>Buat Scorecard Baru</h2>
                        <h3>Pilih Sistem yang akan dinilai</h3>
                        <br />
                        <?php foreach ($sistem as $row) { ?>
                            <input type="radio" name="sistem" value="<?php echo $row->id_sistem; ?>" checked="checked">
                            <label for="'<?php echo $row->id_sistem; ?>'"><?php echo $row->nama_sistem; ?></label>
                            <br />
                        <?php }
                        ?>

                        <h3>Pilih metrics yang akan digunakan dalam Scorecard</h3>
                        <br />
                        <table border="1">
                            <th>Category</th>
                            <th>Metric</th>
                        <?php foreach ($metrics as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $row->tag; ?>
                                </td>
                                <td>
                                    <input type="checkbox" name="metrics[]" value="<?php echo $row->id_metric; ?>">
                                    <label for="'<?php echo $row->id_metric; ?>'"><?php echo $row->teks_metric; ?></label>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                        <br />
                        
                        <!-- <?php print_r($metrics); ?> -->
                        <!-- <?php echo '<script>console.log("Your sistem_view here")</script>'; ?> -->

                        <input type='Submit' value='Generate CSF' />
                    
                    </form>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    

</body>
</html>