<?php
session_start();
// Paparkan ralat untuk memudahkan semakan fasa reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup sementara bagi mengelakkan crash backend
// include('include/checklogin.php');
// include('./include/dbconfig.php');
// check_login();

// Mengambil ID pesakit dari URL (jika tiada, gunakan ID rekaan 'P001')
$vid = isset($_GET['viewid']) ? htmlspecialchars($_GET['viewid']) : 'P001';

// --- TUTORIAL 1: MOCK LOGIK APABILA BUTANG SUBMIT DITEKAN ---
if(isset($_POST['submit']))
{
    // Kita simulasikan mesej berjaya tanpa menyimpan ke dalam Firebase
    echo "<script>alert('Mock UI Success: Your appointment successfully booked');</script>";
    echo "<script>window.location.href ='manage-medhistory.php'</script>";
    exit(); // Sentiasa letak exit selepas redirect script
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nurse | Book Appointment</title>
    
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

        <script src="vendor/jquery/jquery.min.js"></script>

        <script>
        function getdoctor(val) {
            // Memandangkan fail 'get_doctor.php' tiada/ditutup backend, kita terus tukar dropdown menggunakan JS
            if(val == "General Practitioner") {
                $("#doctor").html('<option value="Dr. Wildan">Dr. Wildan (GP)</option><option value="Dr. Amira">Dr. Amira (GP)</option>');
            } else if(val == "Cardiologist") {
                $("#doctor").html('<option value="Dr. Fitri">Dr. Fitri (Cardio)</option>');
            } else {
                $("#doctor").html('<option value="">Select Doctor</option>');
            }
        }

        function getfee(val) {
            // Kosong jika tiada keperluan fi untuk reka bentuk dashboard anda
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
                                    <h1 class="mainTitle">Nurse | Book Appointment</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Nurse</span></li>
                                    <li class="active"><span>Book Appointment for patient</span></li>
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
                                                    <h5 class="panel-title">Book Appointment For Patient</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <form role="form" name="book" method="post" >
                                                        
                                                        <div class="form-group">
                                                            <label for="DoctorSpecialization">Doctor Specialization</label>
                                                            <select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" required="required">
                                                                <option value="">Select Specialization</option>
                                                                <?php 
                                                                // --- TUTORIAL 3: Buat data array mock khas untuk senarai kepakaran ---
                                                                $mock_specializations = [
                                                                    ['Specialization' => 'General Practitioner'],
                                                                    ['Specialization' => 'Cardiologist']
                                                                ];
                                                                foreach($mock_specializations as $row){
                                                                ?>
                                                                <option value="<?php echo htmlentities($row['Specialization']);?>">
                                                                    <?php echo htmlentities($row['Specialization']);?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="doctor">Doctors</label>
                                                            <select name="doctor" class="form-control" id="doctor" required="required">
                                                                <option value="">Select Doctor</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="SelectPatient">Select Patient</label>
                                                            <select name="Patient" class="form-control" required="required">
                                                                <?php
                                                                // --- TUTORIAL 4: Ambil maklumat pesakit berdasarkan $vid dari URL ---
                                                                // Di sini kita simulasikan jika $vid sepadan, paparkan nama Ahmad Bin Ali
                                                                $mock_patients_list = [
                                                                    ['uid' => 'P001', 'name' => 'Ahmad Bin Ali'],
                                                                    ['uid' => 'P002', 'name' => 'Sarah Jane']
                                                                ];

                                                                foreach($mock_patients_list as $row){
                                                                    if($row['uid'] == $vid){
                                                                        $Username = $row['name'];
                                                                ?>
                                                                <option value="<?php echo htmlentities($Username);?>">
                                                                    <?php echo htmlentities($Username);?>
                                                                </option>
                                                                <?php 
                                                                        break;
                                                                    }
                                                                } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="AppointmentDate">Date</label>
                                                            <input class="form-control datepicker" name="appdate" required="required" data-date-format="yyyy-mm-dd" placeholder="Click to select date">
                                                        </div>
                                                                                        
                                                        <div class="form-group">
                                                            <label for="Appointmenttime">Time</label>
                                                            <input class="form-control" name="apptime" id="timepicker1" required="required" placeholder="eg : 10:00 PM">
                                                        </div>                                                                     
                                                        
                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                            Submit Appointment
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
                
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-3d',
                    autoclose: true
                });

                $('#timepicker1').timepicker({
                    minuteStep: 5,
                    showInputs: false,
                    disableFocus: true
                });
            });
        </script>
    </body>
</html>