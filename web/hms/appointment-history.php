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

// Mengambil ID pesakit dari URL secara selamat (jika ada)
$vid = isset($_GET['viewid']) ? htmlspecialchars($_GET['viewid']) : 'MOCK-PATIENT-ID';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nurse | Appointment History</title>
        
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
                                    <h1 class="mainTitle">Nurse  | Appointment History </h1>
                                    <small class="text-muted">Viewing history for Patient ID: <?php echo $vid; ?></small>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Nurse</span>
                                    </li>
                                    <li class="active">
                                        <span>Appointment History</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <p style="color:red;">
                                        <?php echo isset($_SESSION['msg']) ? htmlentities($_SESSION['msg']) : '';?>
                                        <?php if(isset($_SESSION['msg'])) { $_SESSION['msg']=""; } ?>
                                    </p> 
                                    
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Doctor Name </th>
                                                <th>Appointment Date </th>
                                                <th>Appointment Time  </th>
                                                <th>Current Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // --- DATA REKAAN SEJARAH TEMU JANJI (MOCK HISTORY DATA) ---
                                            $mock_history = [
                                                [
                                                    'Docname' => 'Dr. Siti Nurhaliza',
                                                    'date' => '2026-05-10',
                                                    'time' => '11:00 AM',
                                                    'doctorStatus' => 2 // Completed
                                                ],
                                                [
                                                    'Docname' => 'Dr. Wan Azizah',
                                                    'date' => '2026-04-22',
                                                    'time' => '03:00 PM',
                                                    'doctorStatus' => 2 // Completed
                                                ],
                                                [
                                                    'Docname' => 'Dr. Siti Nurhaliza',
                                                    'date' => '2026-03-15',
                                                    'time' => '09:30 AM',
                                                    'doctorStatus' => 0 // Cancelled by user
                                                ]
                                            ];

                                            $cnt = 1;
                                            foreach($mock_history as $row) {
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td><?php echo $row['Docname'];?></td>
                                                <td><?php echo $row['date'];?></td>
                                                <td><?php echo $row['time'];?></td>
                                                <td> 
                                                    <?php 
                                                    if($row['doctorStatus'] == 1) {
                                                        echo "<span class='label label-success'>Active</span>";
                                                    }
                                                    elseif($row['doctorStatus'] == 2) {
                                                        echo "<span class='label label-info'>Completed</span>";
                                                    }
                                                    else {
                                                        echo "<span class='label label-danger'>Cancel by you</span>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php 
                                                $cnt++;
                                            } // End foreach 
                                            ?>
                                        </tbody>
                                    </table>
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