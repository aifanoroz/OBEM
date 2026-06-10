<?php
session_start();
// Paparkan ralat untuk memudahkan semakan fasa reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup sementara bagi mengelakkan crash backend
// include('include/checklogin.php');
// include('include/dbconfig.php');
// check_login();

// Sediakan kata laluan asal lalai untuk tujuan simulasi/mock sahaja
if(!isset($_SESSION['mock_current_password'])) {
    $_SESSION['mock_current_password'] = "123456"; 
}

// --- SIMULASI TINDAKAN SUBMIT BORANG ---
if(isset($_POST['submit']))
{
    $oldpass = $_POST['cpass'];
    $newpass = $_POST['npass'];

    // Simulasi semakan kata laluan semasa
    if($oldpass == $_SESSION['mock_current_password']) {
        // Jika betul, kemas kini kata laluan mock dalam session
        $_SESSION['mock_current_password'] = $newpass;
        $_SESSION['msg_status'] = "success";
        $_SESSION['msg1'] = "Password Changed Successfully !! (New Mock Password: " . htmlspecialchars($newpass) . ")";
    }
    else {
        // Jika salah kata laluan semasa
        $_SESSION['msg_status'] = "danger";
        $_SESSION['msg1'] = "Old Password do not match !! (Hint untuk testing: " . $_SESSION['mock_current_password'] . ")";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nurse | Change Password</title>
        
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
        
        <script type="text/javascript">
        function valid()
        {
            if(document.chngpwd.cpass.value=="")
            {
                alert("Current Password Field is Empty !!");
                document.chngpwd.cpass.focus();
                return false;
            }
            else if(document.chngpwd.npass.value=="")
            {
                alert("New Password Field is Empty !!");
                document.chngpwd.npass.focus();
                return false;
            }
            else if(document.chngpwd.cfpass.value=="")
            {
                alert("Confirm Password Field is Empty !!");
                document.chngpwd.cfpass.focus();
                return false;
            }
            else if(document.chngpwd.npass.value != document.chngpwd.cfpass.value)
            {
                alert("Password and Confirm Password Field do not match !!");
                document.chngpwd.cfpass.focus();
                return false;
            }
            return true;
        }
        </script>
    </head>
    <body>
        <div id="app">      
<?php include('include/sidebar.php');?>
            <div class="app-content">
                
                        <?php include('include/header.php');?>
                        
                <div class="main-content" >
                    <div class="wrap-content container" id="container">
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Nurse | Change Password</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Nurse</span>
                                    </li>
                                    <li class="active">
                                        <span>Change Password</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Change Password</h5>
                                                </div>
                                                <div class="panel-body">
                                                    
                                                    <?php if(isset($_SESSION['msg1']) && $_SESSION['msg1'] != "") { ?>
                                                        <div class="alert alert-<?php echo $_SESSION['msg_status']; ?> alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <?php echo htmlentities($_SESSION['msg1']); ?>
                                                        </div>
                                                        <?php 
                                                        // Kosongkan semula mesej selepas dipaparkan
                                                        $_SESSION['msg1'] = ""; 
                                                        $_SESSION['msg_status'] = "";
                                                        ?>
                                                    <?php } ?>

                                                    <form role="form" name="chngpwd" method="post" onSubmit="return valid();">
                                                        <div class="form-group">
                                                            <label for="cpass">Current Password</label>
                                                            <input type="password" name="cpass" class="form-control" placeholder="Enter Current Password">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="npass">New Password</label>
                                                            <input type="password" name="npass" class="form-control" placeholder="New Password">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="cfpass">Confirm Password</label>
                                                            <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password">
                                                        </div>
                                                        
                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
            <?php include('include/footer.php');?>
            <?php include('include/setting.php');?>
            </div>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>
        <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="vendor/switchery/switchery.min.js"></script>
        <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
        <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="vendor/autosize/autosize.min.js"></script>
        <script src="vendor/selectFx/classie.js"></script>
        <script src="vendor/selectFx/selectFx.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/form-elements.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
                FormElements.init();
            });
        </script>
    </body>
</html>