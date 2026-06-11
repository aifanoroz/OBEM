<?php
session_start();
// Aktifkan paparan ralat untuk memudahkan semakan reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup bagi mengelakkan crash tanpa sambungan Firebase/Backend asli
// include('include/config.php');
// include('include/checklogin.php');
// include('../include/dbconfig.php');
// check_login();

// --- SETUP MOCK DATA (Sama struktur dengan fail manage-users) ---
if (!isset($_SESSION['mock_nurses'])) {
    $_SESSION['mock_nurses'] = [
        'nurse_id_001' => ['name' => 'Nurse Siti Aminah', 'email' => 'siti.aminah@klinikwildan.com', 'regDate' => '10-01-2026 09:30:15 AM', 'updationDate' => ''],
        'nurse_id_002' => ['name' => 'Nurse Noraini Yusuf', 'email' => 'noraini.y@klinikwildan.com', 'regDate' => '15-02-2026 11:15:22 AM', 'updationDate' => ''],
        'nurse_id_003' => ['name' => 'Nurse Farah Diana', 'email' => 'farah.diana@klinikwildan.com', 'regDate' => '03-03-2026 02:45:10 PM', 'updationDate' => ''],
        'nurse_id_004' => ['name' => 'Nurse Khadijah Razak', 'email' => 'khadijah.r@klinikwildan.com', 'regDate' => '20-04-2026 08:05:40 AM', 'updationDate' => '']
    ];
}

// Ambil ID daripada URL, jika tiada setkan ke default 'nurse_id_001' untuk tujuan testing UI
$nid = isset($_GET['id']) ? $_GET['id'] : 'nurse_id_001';
$msg = "";

// Ambil data jururawat berdasarkan ID
if (isset($_SESSION['mock_nurses'][$nid])) {
    $data = $_SESSION['mock_nurses'][$nid];
} else {
    // Fallback sekiranya ID tidak wujud dalam senarai testing
    $data = ['name' => 'Unknown Nurse (Mock Mode)', 'email' => 'unknown@mock.com', 'regDate' => 'N/A', 'updationDate' => ''];
}

// --- SIMULASI TINDAKAN EDIT/UPDATE BORANG ---
if(isset($_POST['submit']))
{
    $fname = $_POST['fname'];
    
    // Kemas kini data dalam session mock jika ID tersebut wujud
    if (isset($_SESSION['mock_nurses'][$nid])) {
        $_SESSION['mock_nurses'][$nid]['name'] = $fname;
        $_SESSION['mock_nurses'][$nid]['updationDate'] = date('d-m-Y h:i:s A'); // Set waktu kemas kini terkini
        
        // Segarkan semula data pemandangan UI
        $data = $_SESSION['mock_nurses'][$nid];
        $msg = "Mock UI Success: Nurse Details updated Successfully";
    } else {
        $msg = "Mock UI Error: Cannot update profile. Nurse ID not found.";
    }
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
                                    
                                    <?php if($msg != "") { ?>
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Status:</strong> <?php echo htmlentities($msg);?>
                                        </div>
                                    <?php } ?>

                                    <div class="row margin-top-30">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Edit Profile</h5>
                                                </div>
                                                <div class="panel-body">
                                                    
                                                    <h4><?php echo htmlentities($data['name']);?>'s Profile</h4>
                                                    <p><b>Profile Reg. Date: </b><?php echo htmlentities(isset($data['regDate']) ? $data['regDate'] : '01-01-2026');?></p>
                                                    
                                                    <?php if(!empty($data['updationDate'])){?>
                                                        <p><b>Profile Last Updation Date: </b><?php echo htmlentities($data['updationDate']);?></p>
                                                    <?php } ?>
                                                    
                                                    <hr />
                                                    
                                                    <form role="form" name="edit" method="post">
                                                        <div class="form-group">
                                                            <label for="fname">Name</label>
                                                            <input type="text" name="fname" class="form-control" value="<?php echo htmlentities($data['name']);?>" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="uemail">Nurse Email</label>
                                                            <input type="email" name="uemail" class="form-control" readonly="readonly" value="<?php echo htmlentities($data['email']);?>">
                                                            <a href="change-emaild.php" class="text-small margin-top-5" style="display:inline-block;">Update your email id</a>
                                                        </div>

                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                            Update
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