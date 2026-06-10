<?php
session_start();
// Paparkan ralat untuk mudahkan debugging UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tutup semakan login backend jika perlu, tetapi kekalkan jika checklogin sudah dimock
// include('include/checklogin.php');
// include('./include/dbconfig.php');
// check_login();

// Logik Butang Tindakan (Mock Action)
if(isset($_GET['cancel'])) {
    echo "<script>alert('Mock Logik: Appointment Cancelled');</script>";
    echo "<script>window.location.href ='appointment.php'</script>";
    exit();
}
elseif(isset($_GET['attend'])){
    echo "<script>alert('Mock Logik: Appointment Mark As Attended');</script>";
    echo "<script>window.location.href ='appointment.php'</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Patient | Appointment </title>
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
                                    <h1 class="mainTitle">Nurse  | Appointment </h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Nurse</span></li>
                                    <li class="active"><span>Appointment</span></li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th class="hidden-xs">Patient Name</th>
                                                <th>Doctor Name</th>
                                                <th>Specialization</th>
                                                <th>Appointment Date </th>
                                                <th>Appointment Time  </th>
                                                <th>Current Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // --- KITA REKA DATA PALSU DI SINI ---
                                            $mock_appointments = [
                                                [
                                                    'uid' => 'P001',
                                                    'Username' => 'Ahmad Bin Ali',
                                                    'Docname' => 'Dr. Siti Nurhaliza',
                                                    'specialization' => 'Obesity Management',
                                                    'date' => '2026-06-15',
                                                    'time' => '10:00 AM',
                                                    'doctorStatus' => 1 // Active
                                                ],
                                                [
                                                    'uid' => 'P002',
                                                    'Username' => 'Sarah Jane',
                                                    'Docname' => 'Dr. Wan Azizah',
                                                    'specialization' => 'Dietitian Consultation',
                                                    'date' => '2026-06-14',
                                                    'time' => '02:30 PM',
                                                    'doctorStatus' => 2 // Completed
                                                ],
                                                [
                                                    'uid' => 'P003',
                                                    'Username' => 'Mohd Khairul',
                                                    'Docname' => 'Dr. Siti Nurhaliza',
                                                    'specialization' => 'Obesity Management',
                                                    'date' => '2026-06-12',
                                                    'time' => '09:00 AM',
                                                    'doctorStatus' => 0 // Cancelled
                                                ]
                                            ];

                                            $cnt = 1;
                                            foreach($mock_appointments as $row){     
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td class="hidden-xs"><?php echo $row['Username'];?></td>
                                                <td><?php echo $row['Docname'];?></td>
                                                <td><?php echo $row['specialization'];?></td>
                                                <td><?php echo $row['date'];?></td>
                                                <td><?php echo $row['time'];?></td>
                                                <td>
                                                    <?php 
                                                    if($row['doctorStatus'] == 1) { echo "<span class='label label-success'>Active</span>"; }
                                                    elseif($row['doctorStatus'] == 2) { echo "<span class='label label-info'>Completed</span>"; }
                                                    else { echo "<span class='label label-danger'>Cancelled</span>"; }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <?php if($row['doctorStatus'] == 1) { ?>
                                                            <a href="appointment.php?id=<?php echo $row['uid']?>&attend=update" onClick="return confirm('Are you sure you want to mark this appointment as attended ?')" class="btn btn-transparent btn-xs tooltips" title="Mark as Attended"><i class="fa fa-check text-success"></i></a> || 
                                                            <a href="appointment.php?id=<?php echo $row['uid']?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment ?')" class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment"><i class="fa fa-ban text-danger"></i></a>
                                                        <?php } elseif($row['doctorStatus'] == 2) { ?>
                                                            <span class="text-muted"><small>Mark Attended</small></span>
                                                        <?php } else { ?>
                                                            <span class="text-muted"><small>Cancelled</small></span>
                                                        <?php } ?>
                                                    </div>
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