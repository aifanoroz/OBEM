<?php
session_start();
// Aktifkan pemantauan ralat untuk fasa pengiraan UI mockup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tutup sambungan pangkalan data lama & Firebase Realtime Database asli
// include('include/config.php');
// include('../include/dbconfig.php');

include('include/checklogin.php');
check_login();

date_default_timezone_set('Asia/Kuala_Lumpur');

// Setup struktur asas sesi data kepakaran doktor (jika fail doctor-specialization belum dipanggil)
if (!isset($_SESSION['mock_specializations'])) {
    $_SESSION['mock_specializations'] = [
        ['id' => 1, 'specilization' => 'Dietitian / Nutritionist'],
        ['id' => 2, 'specilization' => 'Bariatric Surgeon'],
        ['id' => 3, 'specilization' => 'Endocrinologist']
    ];
}

// Setup sesi array data bagi struktur senarai doktor (jika tiada)
if (!isset($_SESSION['mock_doctors'])) {
    $_SESSION['mock_doctors'] = [];
}

// --- SIMULASI TINDAKAN BORANG DIHANTAR (SUBMIT) ---
if(isset($_POST['submit']))
{   
    $docspecialization = htmlspecialchars($_POST['Doctorspecialization']);
    $docname           = htmlspecialchars($_POST['docname']);
    $docaddress        = htmlspecialchars($_POST['clinicaddress']);
    $doccontactno      = htmlspecialchars($_POST['doccontact']);
    $docemail          = htmlspecialchars($_POST['docemail']);
    $password          = md5($_POST['npass']); // Kekalkan MD5 simulasi dashboard asal
    $current_date      = date('m/d/Y h:i:s a');

    // Bina Unique Key ala-ala Firebase Push Key
    $mock_firebase_key = "mock_doc_" . bin2hex(random_bytes(4));

    // Bentukkan objek data doktor
    $new_doctor = [
        'key'            => $mock_firebase_key,
        'name'           => $docname,
        'Specialization' => $docspecialization,
        'creationDate'   => $current_date,
        'address'        => $docaddress,
        'contactno'      => $doccontactno,
        'docEmail'       => $docemail,
        'password'       => $password
    ];

    // Simpan ke dalam storan array session global doktor
    $_SESSION['mock_doctors'][] = $new_doctor;

    // Cetak mesej makluman JavaScript bertindak balas dan bawa ke pengurusan senarai doktor
    echo "<script>alert('Doctor info added Successfully (Mock Mode)');</script>";
    echo "<script>window.location.href ='manage-doctors.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Add Doctor</title>
        
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
            // Simulasi semakan UI: memandangkan fail check_availability.php mungkin memerlukan pangkalan data asli, 
            // fungsi ini dibiarkan sedia ada atau anda boleh tambah respon visual teks ringkas.
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#docemail").val(),
                type: "POST",
                success: function(data){
                    $("#email-availability-status").html("<span style='color:green;'>Email format valid (Mock Check Bypass).</span>");
                    $("#loaderIcon").hide();
                },
                error: function (){
                    $("#loaderIcon").hide();
                }
            });
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
                                    <h1 class="mainTitle">Admin | Add Doctor</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>Add Doctor</span>
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
                                                    <h5 class="panel-title">Add Doctor</h5>
                                                </div>
                                                <div class="panel-body">
                                                    
                                                    <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                                                        <div class="form-group">
                                                            <label for="DoctorSpecialization">
                                                                Doctor Specialization
                                                            </label>
                                                            <select name="Doctorspecialization" class="form-control" required="true">
                                                                <option value="">Select Specialization</option>
<?php 
// Menggantikan gelung mysqli_fetch_array lama kepada bacaan senarai sesi tatasusunan dinamik
foreach($_SESSION['mock_specializations'] as $row)
{
?>
                                                                <option value="<?php echo htmlentities($row['specilization']);?>">
                                                                    <?php echo htmlentities($row['specilization']);?>
                                                                </option>
<?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="doctorname">
                                                                 Doctor Name
                                                            </label>
                                                            <input type="text" name="docname" class="form-control" placeholder="Enter Doctor Name" required="true">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="address">
                                                                 Doctor Clinic Address
                                                            </label>
                                                            <textarea name="clinicaddress" class="form-control" placeholder="Enter Doctor Clinic Address" required="true"></textarea>
                                                        </div>
                                                            
                                                        <div class="form-group">
                                                            <label for="doccontact">
                                                                 Doctor Contact no
                                                            </label>
                                                            <input type="text" name="doccontact" class="form-control" placeholder="Enter Doctor Contact no" required="true">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="docemail">
                                                                 Doctor Email
                                                            </label>
                                                            <input type="email" id="docemail" name="docemail" class="form-control" placeholder="Enter Doctor Email id" required="true" onBlur="checkemailAvailability()">
                                                            <span id="email-availability-status"></span>
                                                            <span id="loaderIcon" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Checking...</span>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="npass">
                                                                 Password
                                                            </label>
                                                            <input type="password" name="npass" class="form-control" placeholder="New Password" required="required">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="cfpass">
                                                                 Confirm Password
                                                            </label>
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