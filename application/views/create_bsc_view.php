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
            <p>Pilih perspektif dari sistem yang akan dievaluasi</p>
            <br />
            <form action='<?php echo base_url();?>create_bsc/generate_system' method='post'>
                <div class="table">
                    <table class="table">
                        <th>Perspektif</th>
                        <th>Sistem Terkait</th>
                        <tr>
                            <td>
                                <input type="radio" name="perspective" value="Business Value" checked="checked">
                                <label for="Business Value">Business Value</label>
                                <p>Perspektif pada Balanced Scorecard : Financial</p>
                            </td>
                            <td>
                                <?php foreach ($sistemBV as $row) { ?>
                                    <ul>
                                        <li>
                                            <?php echo $row->nama_sistem; ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" name="perspective" value="User Orientation">
                                <label for="User Orientation">User Orientation</label>
                                <p>Perspektif pada Balanced Scorecard : Customer</p>
                            </td>
                            <td>
                                <?php foreach ($sistemUO as $row) { ?>
                                    <ul>
                                        <li>
                                            <?php echo $row->nama_sistem; ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" name="perspective" value="Internal Process">
                                <label for="Internal Process">Internal Process</label>
                                <p>Perspektif pada Balanced Scorecard : Internal Business</p>
                            </td>
                            <td>
                                <?php foreach ($sistemIP as $row) { ?>
                                    <ul>
                                        <li>
                                            <?php echo $row->nama_sistem; ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="radio" name="perspective" value="Future Readiness">
                                <label for="Future Readiness">Future Readiness</label>
                                <p>Perspektif pada Balanced Scorecard : Learning and Growth</p>
                            </td>
                            <td>
                                <?php foreach ($sistemFR as $row) { ?>
                                    <ul>
                                        <li>
                                            <?php echo $row->nama_sistem; ?>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- <br /> -->
                <input class="btn btn-default pull-right" type='Submit' value='Lanjut pilih sistem' />
            
            </form>
        </div>
    </div>
    

</body>
</html>