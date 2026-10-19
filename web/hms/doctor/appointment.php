<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Doctor | Appointment </title>
        
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
                                    <h1 class="mainTitle">Doctor  | Appointment </h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Doctor </span>
                                    </li>
                                    <li class="active">
                                        <span>Appointment </span>
                                    </li>
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
                                                <th>Specialization</th>
                                                <th>Appointment Date </th>
                                                <th>Appointment Time  </th>
                                                <th>Current Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="center">1.</td>
                                                <td class="hidden-xs">Ahmad Fauzi</td>
                                                <td>Klinik Wildan (Obesity Specialist)</td>
                                                <td>2026-06-28</td>
                                                <td>10:00 AM</td>
                                                <td>Active</td>
                                                <td>
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <a href="#" onClick="return confirm('Are you sure you want to mark this appointment as attended ?')" class="btn btn-transparent btn-xs tooltips" title="Mark as Attended" tooltip-placement="top"><i class="fa fa-check"></i></a> || 
                                                        <a href="#" onClick="return confirm('Are you sure you want to cancel this appointment ?')" class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment" tooltip-placement="top"><i class="fa fa-ban"></i></a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="center">2.</td>
                                                <td class="hidden-xs">Siti Nurhaliza</td>
                                                <td>Klinik Wildan (Obesity Specialist)</td>
                                                <td>2026-06-24</td>
                                                <td>02:30 PM</td>
                                                <td>Completed</td>
                                                <td>
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        Mark Attended
                                                    </div>
                                                </td>
                                            </tr>
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