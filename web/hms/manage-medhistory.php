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

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Nurse| View Medical History</title>
        
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
                                    <h1 class="mainTitle">Nurse | General Information</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Nurse</span>
                                    </li>
                                    <li class="active">
                                        <span>View Medical History</span>
                                    </li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">View <span class="text-bold">General Information</span></h5>
                                    
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Patient Name</th>
                                                <th>Patient Age</th>
                                                <th>Patient Gender </th>
                                                <th>Creation Date </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // --- DATA REKAAN MAKLUMAT KESIHATAN PESAKIT (MOCK PATIENT MEDICAL HISTORY) ---
                                            $mock_patients = [
                                                [
                                                    'uid' => 'P001',
                                                    'name' => 'Ahmad Bin Ali',
                                                    'age' => '34',
                                                    'gender' => 'Male',
                                                    'date' => '2026-05-12'
                                                ],
                                                [
                                                    'uid' => 'P002',
                                                    'name' => 'Sarah Jane',
                                                    'age' => '28',
                                                    'gender' => 'Female',
                                                    'date' => '2026-05-18'
                                                ],
                                                [
                                                    'uid' => 'P003',
                                                    'name' => 'Mohd Khairul',
                                                    'age' => '45',
                                                    'gender' => 'Male',
                                                    'date' => '2026-06-02'
                                                ]
                                            ];

                                            $cnt = 1; // Isytihar pemula pembilang nombor siri dengan betul
                                            foreach($mock_patients as $row){
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td class="hidden-xs"><?php echo $row['name'];?></td>
                                                <td><?php echo $row['age'];?></td>
                                                <td><?php echo $row['gender'];?></td>
                                                <td><?php echo $row['date'];?></td>
                                                <td>
                                                    <a href="view-medhistory.php?viewid=<?php echo $row['uid'];?>" class="btn btn-transparent btn-xs" title="View Detailed Medical History">
                                                        <i class="fa fa-eye text-primary" style="font-size: 16px;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $cnt++; // Tambah nilai pembilang
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