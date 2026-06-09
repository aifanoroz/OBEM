<?php
session_start();
// Pasang error reporting ke 1 jika mahu melakukan debug semasa fasa pembangunan
error_reporting(0);
include('../include/dbconfig.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{   
    $nurname = $_POST['nursename'];
    $nuremail = $_POST['nurseemail'];
    // Gunakan password_hash() jika mahu sekuriti moden, 
    // tetapi jika sistem sedia ada guna md5, kita kekalkan md5 buat masa ini.
    $password = md5($_POST['npass']);

    // 1. Dapatkan rujukan rujukan (Reference) ke Firebase dahulu
    $ref = "Nurse/";
    $newDataRef = $database->getReference($ref)->push(); // Guna push kosong untuk dapatkan Key dahulu
    $key = $newDataRef->getKey();

    // 2. Masukkan sekali 'key' bersama data jururawat supaya tidak perlu operasi update berasingan
    $nurse = [
        'key' => $key,
        'name' => $nurname,
        'email' => $nuremail,
        'password' => $password
    ];

    // 3. Simpan terus set data lengkap ke Firebase
    $pushdata = $newDataRef->set($nurse);

    if($pushdata)
    {
        echo "<script>alert('Nurse info added Successfully');</script>";
        echo "<script>window.location.href ='manage-users.php'</script>";
    }
    else 
    {
        echo "<script>alert('Failed to add Nurse info. Please try again.');</script>";
    }
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
        // Memastikan jQuery sedia digunakan sebelum AJAX dipanggil
        function checkemailAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_nurse.php",
                data: 'emailid=' + $("#nurseemail").val(),
                type: "POST",
                success: function(data){
                    $("#email-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function (){}
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
                                                            <span id="email-availability-status"></span>
                                                            <span id="loaderIcon" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Checking...</span>
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