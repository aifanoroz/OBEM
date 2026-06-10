<?php
session_start();
// Paparkan ralat untuk memudahkan semakan fasa reka bentuk UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup sementara bagi mengelakkan crash backend
// include('./include/dbconfig.php');
// include('include/checklogin.php');
// check_login();

// Mengambil ID pesakit dari URL (jika tiada, gunakan ID rekaan 'P001')
$vid = isset($_GET['viewid']) ? htmlspecialchars($_GET['viewid']) : 'P001';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patients | Medical History</title>
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
                                    <h1 class="mainTitle">Nurse | Patient's Medical History</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Patient</span></li>
                                    <li class="active"><span>Medical History</span></li>
                                </ol>
                            </div>
                        </section>
                        
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">Patients <span class="text-bold">Medical History</span></h5>
                                    
                                    <?php
                                    // --- 1. MOCK DATA PERIBADI PESAKIT (Ganti mysqli_query) ---
                                    $mock_patient_details = [
                                        'PatientName' => 'Ahmad Bin Ali',
                                        'PatientEmail' => 'ahmad.ali@example.com',
                                        'PatientContno' => '012-3456789',
                                        'PatientAdd' => 'No. 123, Jalan Kemaman, 24000 Chukai, Terengganu',
                                        'PatientGender' => 'Male',
                                        'PatientAge' => '34',
                                        'PatientMedhis' => 'High blood pressure family history, currently managing obesity.',
                                        'CreationDate' => '2026-05-12'
                                    ];
                                    ?>
                                    
                                    <table border="1" class="table table-bordered">
                                        <tr align="center">
                                            <td colspan="4" style="font-size:20px; color:blue; font-weight:bold;">
                                                Patient Details
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Patient Name</th>
                                            <td><?php echo $mock_patient_details['PatientName'];?></td>
                                            <th>Patient Email</th>
                                            <td><?php echo $mock_patient_details['PatientEmail'];?></td>
                                        </tr>
                                        <tr>
                                            <th>Patient Mobile Number</th>
                                            <td><?php echo $mock_patient_details['PatientContno'];?></td>
                                            <th>Patient Address</th>
                                            <td><?php echo $mock_patient_details['PatientAdd'];?></td>
                                        </tr>
                                        <tr>
                                            <th>Patient Gender</th>
                                            <td><?php echo $mock_patient_details['PatientGender'];?></td>
                                            <th>Patient Age</th>
                                            <td><?php echo $mock_patient_details['PatientAge'];?></td>
                                        </tr>
                                        <tr>
                                            <th>Patient Medical History(if any)</th>
                                            <td><?php echo $mock_patient_details['PatientMedhis'];?></td>
                                            <th>Patient Reg Date</th>
                                            <td><?php echo $mock_patient_details['CreationDate'];?></td>
                                        </tr>
                                    </table>

                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; margin-top: 20px;">
                                        <thead>
                                            <tr align="center" class="bg-light">
                                                <th colspan="7" style="font-size: 16px; font-weight: bold;">Medical History Logs</th> 
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Blood Pressure (mmHg)</th>
                                                <th>Weight (kg)</th>
                                                <th>Blood Sugar (mmol/L)</th>
                                                <th>Cholesterol (mmol/L)</th>
                                                <th>BMI</th>
                                                <th>Check-up Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  
                                            // --- 2. MOCK DATA SEJARAH KESIHATAN (Ganti Firebase GetReference) ---
                                            $mock_health_history = [
                                                [
                                                    'systolic' => '135',
                                                    'diastolic' => '85',
                                                    'weight' => '88.5',
                                                    'bsugar' => '6.1',
                                                    'tweight' => '5.4', // Jumlah kolesterol
                                                    'BMI' => '28.9',
                                                    'date' => '2026-06-01'
                                                ],
                                                [
                                                    'systolic' => '140',
                                                    'diastolic' => '90',
                                                    'weight' => '90.2',
                                                    'bsugar' => '6.5',
                                                    'tweight' => '5.8',
                                                    'BMI' => '29.4',
                                                    'date' => '2026-05-15'
                                                ],
                                                [
                                                    'systolic' => '130',
                                                    'diastolic' => '82',
                                                    'weight' => '91.0',
                                                    'bsugar' => '5.9',
                                                    'tweight' => '5.2',
                                                    'BMI' => '29.7',
                                                    'date' => '2026-04-10'
                                                ]
                                            ];

                                            $cnt = 1;
                                            foreach($mock_health_history as $row){
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt;?>.</td>
                                                <td><?php echo $row['systolic']." / ".$row['diastolic']?></td>
                                                <td><?php echo $row['weight']?></td>
                                                <td><?php echo $row['bsugar']?></td> 
                                                <td><?php echo $row['tweight']?></td>
                                                <td><?php echo $row['BMI']?></td>
                                                <td><?php echo $row['date']?></td> 
                                            </tr>
                                            <?php 
                                                $cnt++;
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                    <p align="center" style="margin-top: 25px;">  
                                        <a href="book-appointment.php?viewid=<?php echo $vid;?>" class="btn btn-primary btn-lg">
                                            <i class="fa fa-calendar"></i> Book Appointment
                                        </a>
                                    </p>                      
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