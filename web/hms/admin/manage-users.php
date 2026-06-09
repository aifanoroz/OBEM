<?php
session_start();
error_reporting(0);
include('../include/dbconfig.php');
include('include/checklogin.php');
check_login();

if(isset($_GET['del']))
{
    $key = $_GET['id'];
    $ref = "Nurse/$key";
    $delete = $database->getReference($ref)->remove();
    
    if($delete){
        $_SESSION['msg'] = "Nurse data deleted successfully!!";
    } else {
        $_SESSION['msg'] = "Failed to delete data.";
    }
    // Redirect semula ke fail manage_users.php selepas padam
    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Manage Users</title>
        
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
        <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
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
                                    <h1 class="mainTitle">Admin | Manage Nurses</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Admin</span></li>
                                    <li class="active"><span>Manage Nurses</span></li>
                                </ol>
                            </div>
                        </section>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Nurses</span></h5>
                                    
                                    <?php if(isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo htmlentities($_SESSION['msg']);?>
                                            <?php unset($_SESSION['msg']); ?>
                                        </div>
                                    <?php } ?>

                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$ref = "Nurse";
$fetchdata = $database->getReference($ref)->getValue();
         
$cnt = 1;
if(!empty($fetchdata)) {
    foreach($fetchdata as $key => $row) {
?>
                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td><?php echo htmlentities($row['name']);?></td>
                                                <td><?php echo htmlentities($row['email']);?></td>
                                                <td>
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <a href="edit-nurse.php?id=<?php echo $key;?>" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>           
                                                        
                                                        <a href="manage_users.php?id=<?php echo $key;?>&del=delete" onClick="return confirm('Are you sure you want to delete this nurse?')" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove">
                                                            <i class="fa fa-times fa-white" style="color:red;"></i>
                                                        </a>
                                                    </div>
                                                    
                                                    <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                        <div class="btn-group" dropdown>
                                                            <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                                <li><a href="edit-nurse.php?id=<?php echo $key;?>">Edit</a></li>
                                                                <li><a href="manage_users.php?id=<?php echo $key;?>&del=delete" onClick="return confirm('Are you sure?')">Remove</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
<?php 
        $cnt++;
    }
} else {
?>
                                            <tr>
                                                <td colspan="4" class="center text-danger">No nurse records found.</td>
                                            </tr>
<?php } ?>
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