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

    <title>New Account</title>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <h2>Buat akun baru</h2>
            <div id='form_akun_baru'>
                <form action="<?php echo base_url();?>organisasi/akun_baru" method='post'>
                    <table>
                        <tr>
                            <td height="50" width="150">
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

                    <input type='Submit' class="btn btn-default" value='Daftar' />
                    <a href="<?php echo base_url();?>"><button type="button" class="btn btn-default">Masuk</button></a>

                </form>
            </div>
        </div>
    </div>
    

</body>
</html>