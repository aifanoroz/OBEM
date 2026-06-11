<?php
session_start();
// Aktifkan error reporting untuk fasa pembinaan UI
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ditutup bagi mengelakkan ralat fungsi tanpa backend asal
include('include/checklogin.php');
check_login();

// --- SETUP MOCK DATA DATABASE DALAM SESSION ---
if (!isset($_SESSION['mock_specializations'])) {
    $_SESSION['mock_specializations'] = [
        [
            'id' => 1,
            'specilization' => 'Dietitian / Nutritionist',
            'creationDate' => '10-01-2026 10:00:00 AM',
            'updationDate' => '15-02-2026 11:30:00 AM'
        ],
        [
            'id' => 2,
            'specilization' => 'Bariatric Surgeon',
            'creationDate' => '12-01-2026 02:20:00 PM',
            'updationDate' => ''
        ],
        [
            'id' => 3,
            'specilization' => 'Endocrinologist',
            'creationDate' => '01-02-2026 09:15:00 AM',
            'updationDate' => ''
        ]
    ];
}

$msg = "";

// --- SIMULASI TINDAKAN TAMBAH DATA (SUBMIT) ---
if(isset($_POST['submit']))
{
    $new_spec = htmlspecialchars($_POST['doctorspecilization']);
    
    // Cari ID terbesar yang sedia ada untuk dijana ID seterusnya
    $max_id = 0;
    foreach ($_SESSION['mock_specializations'] as $item) {
        if ($item['id'] > $max_id) {
            $max_id = $item['id'];
        }
    }
    $new_id = $max_id + 1;

    // Masukkan ke dalam array session global
    $_SESSION['mock_specializations'][] = [
        'id' => $new_id,
        'specilization' => $new_spec,
        'creationDate' => date('d-m-Y h:i:s A'),
        'updationDate' => ''
    ];

    $msg = "Doctor Specialization (" . $new_spec . ") added successfully (Mock Mode) !!";
}

// --- SIMULASI TINDAKAN PADAM DATA (DELETE) ---
if(isset($_GET['del']) && isset($_GET['id']))
{
    $del_id = (int)$_GET['id'];
    
    // Cari dan buang elemen spesifik berdasarkan ID
    foreach ($_SESSION['mock_specializations'] as $key => $item) {
        if ($item['id'] == $del_id) {
            unset($_SESSION['mock_specializations'][$key]);
            // Susun semula susunan indeks array
            $_SESSION['mock_specializations'] = array_values($_SESSION['mock_specializations']);
            $msg = "Data deleted successfully (Mock Mode) !!";
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Doctor Specialization</title>
    
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
                                    <h1 class="mainTitle">Admin | Add Doctor Specialization</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li>
                                        <span>Admin</span>
                                    </li>
                                    <li class="active">
                                        <span>Add Doctor Specialization</span>
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
                                        <div class="col-lg-6 col-md-12">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">Doctor Specialization</h5>
                                                </div>
                                                <div class="panel-body">
                                                    <form role="form" name="dcotorspcl" method="post" >
                                                        <div class="form-group">
                                                            <label for="doctorspecilization">
                                                                Doctor Specialization
                                                            </label>
                                                            <input type="text" name="doctorspecilization" class="form-control" placeholder="Enter Doctor Specialization" required>
                                                        </div>
                                                        
                                                        <button type="submit" name="submit" class="btn btn-o btn-primary">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row margin-top-20">
                                        <div class="col-md-12">
                                            <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Doctor Specialization</span></h5>
                                            
                                            <table class="table table-hover" id="sample-table-1">
                                                <thead>
                                                    <tr>
                                                        <th class="center">#</th>
                                                        <th>Specialization</th>
                                                        <th class="hidden-xs">Creation Date</th>
                                                        <th>Updation Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?php
$cnt = 1;
// Membaca baris tatasusunan dinamik daripada $_SESSION secara langsung
foreach($_SESSION['mock_specializations'] as $row)
{
?>
                                                    <tr>
                                                        <td class="center"><?php echo $cnt;?>.</td>
                                                        <td><?php echo htmlentities($row['specilization']);?></td>
                                                        <td class="hidden-xs"><?php echo htmlentities($row['creationDate']);?></td>
                                                        <td><?php echo htmlentities($row['updationDate'] ? $row['updationDate'] : '-');?></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                <a href="edit-doctor-specialization.php?id=<?php echo urlencode($row['id']);?>" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>
                                                                
                                                                <a href="doctor-specialization.php?id=<?php echo urlencode($row['id']);?>&del=delete" onClick="return confirm('Are you sure you want to delete this specialization?')" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                                            </div>
                                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                <div class="btn-group" dropdown is-open="status.isopen">
                                                                    <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
                                                                        <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                        <li><a href="edit-doctor-specialization.php?id=<?php echo urlencode($row['id']);?>">Edit</a></li>
                                                                        <li><a href="doctor-specialization.php?id=<?php echo urlencode($row['id']);?>&del=delete" onClick="return confirm('Are you sure?')">Remove</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
<?php 
    $cnt++;
} 
if(empty($_SESSION['mock_specializations'])) {
    echo "<tr><td colspan='5' class='text-center text-muted'>No specialization records found in this mock session.</td></tr>";
}
?>
                                                </tbody>
                                            </table>
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