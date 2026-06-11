<?php
session_start();
// Paparkan ralat untuk memudahkan semakan fasa reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup sementara bagi mengelakkan crash backend
// include('include/dbconfig.php');
// include('include/checklogin.php');
// check_login();

// Sediakan mesej kosong pada mulanya
$msg = "";

// --- TUTORIAL 1: SIMULASI TINDAKAN SUBMIT BORANG ---
if(isset($_POST['submit']))
{
    // Ambil nama baharu yang ditaip oleh pengguna untuk tujuan demonstrasi dinamik
    $mock_new_name = htmlspecialchars($_POST['fname']);
    $msg = "Mock UI Success: Your Profile updated Successfully to '" . $mock_new_name . "'";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nurse | Edit Profile</title>
        
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
                                    <h1 class="mainTitle">Nurse | Edit Profile</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Nurse </span>
                                    </li>
                                    <li class="active">
                                        <span>Edit Profile</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if($msg) { ?>
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="text" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Edit Profile</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <?php 
                                                    // --- TUTORIAL 2: SEDIAKAN DATA REKAAN JURURAWAT ---
                                                    // Jika pengguna sudah tekan submit, kita guna nama baharu, jika belum guna nama asal.
                                                    $current_name = isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : 'Nurse Siti Aminah';

                                                    $data = [
                                                        'name' => $current_name,
                                                        'email' => 'siti.aminah@klinikwildan.com',
                                                        'regDate' => '2026-02-15 09:30:22',
                                                        'updationDate' => isset($_POST['submit']) ? date('Y-m-d H:i:s') : '2026-05-10 14:22:05'
                                                    ];
                                                    ?>
                                                    <h4><?php echo htmlentities($data['name']);?>'s Profile</h4>
                                                    <p><b>Profile Reg. Date: </b><?php echo htmlentities($data['regDate']);?></p>
                                                    <?php if($data['updationDate']){?>
                                                    <p><b>Profile Last Updation Date: </b><?php echo htmlentities($data['updationDate']);?></p>
                                                    <?php } ?>
                                                    <hr />                                                    
                                                    <form role="form" name="edit" method="post">
                                                        
                                                        <div class="form-group">
                                                            <label for="fname">Name</label>
                                                            <input type="text" name="fname" class="form-control" value="<?php echo htmlentities($data['name']);?>" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="uemail">User Email</label>
                                                            <input type="email" name="uemail" class="form-control" readonly="readonly" value="<?php echo htmlentities($data['email']);?>">
                                                            <a href="change-emaild.php" class="text-small margin-top-5" style="display:inline-block;">Update your email id</a>
                                                        </div>

                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                            Update Profile
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