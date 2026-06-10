<?php
session_start();
// Paparkan ralat untuk memudahkan semakan fasa reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup sementara bagi mengelakkan crash backend
// include('../include/dbconfig.php');
// include('include/checklogin.php');
// check_login();

// --- SETUP MOCK DATA (Kekalkan struktur session yang sama) ---
if (!isset($_SESSION['mock_nurses'])) {
    $_SESSION['mock_nurses'] = [
        'nurse_id_001' => ['name' => 'Nurse Siti Aminah', 'email' => 'siti.aminah@klinikwildan.com', 'regDate' => '10-01-2026 09:30:15 AM', 'updationDate' => ''],
        'nurse_id_002' => ['name' => 'Nurse Noraini Yusuf', 'email' => 'noraini.y@klinikwildan.com', 'regDate' => '15-02-2026 11:15:22 AM', 'updationDate' => ''],
        'nurse_id_003' => ['name' => 'Nurse Farah Diana', 'email' => 'farah.diana@klinikwildan.com', 'regDate' => '03-03-2026 02:45:10 PM', 'updationDate' => ''],
        'nurse_id_004' => ['name' => 'Nurse Khadijah Razak', 'email' => 'khadijah.r@klinikwildan.com', 'regDate' => '20-04-2026 08:05:40 AM', 'updationDate' => '']
    ];
}

// --- TUTORIAL 1: MOCK PROSES DAFTAR (INSERT DATA TO SESSION) ---
if(isset($_POST['submit']))
{   
    $nurname = htmlspecialchars($_POST['nursename']);
    $nuremail = htmlspecialchars($_POST['nurseemail']);
    
    // Reka ID unik baharu berasaskan fungsi microtime komputer
    $new_key = 'nurse_id_' . time();

    // Masukkan data input ke dalam $_SESSION global mock database
    $_SESSION['mock_nurses'][$new_key] = [
        'name' => $nurname,
        'email' => $nuremail,
        'regDate' => date('d-m-Y h:i:s A'),
        'updationDate' => ''
    ];

    // Paparkan kotak amaran berjaya dan lompat kembali ke halaman senarai jadual
    $_SESSION['msg'] = "Mock UI Success: New nurse (" . $nurname . ") added successfully!!";
    echo "<script>alert('Nurse info added Successfully (Mock Mode)');</script>";
    echo "<script>window.location.href ='manage_users.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Add Nurse</title>
        
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/plugins.css">
        <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

        <script type="text/javascript">
        function valid()
        {
            if(document.adddoc.npass.value != document.adddoc.cfpass.value)
            {
                alert("Password and Confirm Password Field do not match !!");
                document.adddoc.cfpass.focus();
                return false;
            }
            return true;
        }
        </script>

        <script>
        function checkemailAvailability() {
            var email = $("#nurseemail").val();
            if(email != "") {
                $("#loaderIcon").show();
                
                // Pintasan simulasi tanpa memerlukan fail 'check_nurse.php' backend
                setTimeout(function(){
                    $("#loaderIcon").hide();
                    // Contoh mudah: jika input mengandungi perkataan 'taken', kita acah ia sudah didaftar
                    if(email.includes("taken") || email == "siti.aminah@klinikwildan.com") {
                        $("#email-availability-status").html("<span style='color:red;'> Email already exists. Please try another.</span>");
                        $("#submit").prop('disabled', true);
                    } else {
                        $("#email-availability-status").html("<span style='color:green;'> Email available for registration.</span>");
                        $("#submit").prop('disabled', false);
                    }
                }, 600); // Acah-acah sistem loading selama 0.6 saat
            }
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
                                    <h1 class="mainTitle">Admin | Add Nurse</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Admin</span></li>
                                    <li class="active"><span>Add Nurse</span></li>
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
                                                    <h5 class="panel-title">Add Nurse Details</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                                                        
                                                        <div class="form-group">
                                                            <label for="nursename">Nurse Name</label>
                                                            <input type="text" name="nursename" class="form-control" placeholder="Enter Nurse Name" required="true">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="nurseemail">Nurse Email</label>
                                                            <input type="email" id="nurseemail" name="nurseemail" class="form-control" placeholder="Enter Nurse Email ID" required="true" onBlur="checkemailAvailability()">
                                                            <span id="email-availability-status" style="font-size: 12px; display: block; margin-top: 5px;"></span>
                                                            <span id="loaderIcon" style="display:none; font-size: 12px; color: gray;"><i class="fa fa-spinner fa-spin"></i> Checking availability...</span>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="npass">Password</label>
                                                            <input type="password" name="npass" class="form-control" placeholder="New Password" required="required">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="cfpass">Confirm Password</label>
                                                            <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password" required="required">
                                                        </div>
                                                        
                                                        <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
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
        <script src="assets/js/main.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
            });
        </script>
    </body>
</html> 