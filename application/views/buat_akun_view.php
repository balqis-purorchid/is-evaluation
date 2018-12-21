<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" class="full">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/bootstrap.min.css"/>
    <script src="http://localhost/is-evaluation/assets/jQuery/jquery-3.3.1.min.js"></script>
    <script src="http://localhost/is-evaluation/assets/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="http://localhost/is-evaluation/assets/css/custom.css"/>

    <title>New Account</title>
</head>
<body background="http://localhost/is-evaluation/assets/img/conferencehall.jpg" style="margin-top: 50px">
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="panel panel-transparent">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="color: white;">IS / IT Evaluation Tools</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url();?>organisasi/akun_baru" method='post'>
                            <table>
                                <tr>
                                    <td height="50" width="200">
                                        <label for='orgname'>Organization Name</label>
                                    </td>
                                    <td height="50">
                                        <input type='text' name='orgname' size='100' required /><br />
                                    </td>
                                </tr><tr>
                                    <td height="50">
                                        <label for='username'>Username</label>
                                    </td>
                                    <td height="50">
                                        <input type='text' name='username' size='25' required /><br />
                                    </td>
                                </tr>
                                <tr>
                                    <td height="50">
                                        <label for='password'>Password</label>
                                    </td>
                                    <td height="50">
                                        <input type='password' name='password' size='25' required /><br />                            
                                    </td>
                                </tr>
                            </table>

                            <a href="<?php echo base_url();?>"><button type="button" class="btn btn-default pull-right">Kembali ke halaman Login</button></a>
                            <input type='Submit' class="btn btn-default pull-right" value='Daftar' />

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</body>
</html>