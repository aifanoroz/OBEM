<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Doctor | Manage Patients</title>
    
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
                  <h1 class="mainTitle">Doctor | Manage Patients</h1>
                </div>
                <ol class="breadcrumb">
                  <li>
                    <span>Doctor</span>
                  </li>
                  <li class="active">
                    <span>Manage Patients</span>
                  </li>
                </ol>
              </div>
            </section>
            
            <div class="container-fluid container-fullw bg-white">
              <div class="row">
                <div class="col-md-12">
                  <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
                  
                  <table border="1" class="table table-bordered">
                    <tr align="center">
                      <td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
                    </tr>
                    <tr>
                      <th>Patient Name</th>
                      <td>Ahmad Zaki Bin Rahman</td>
                      <th>Patient Email</th>
                      <td>ahmadzaki@gmail.com</td>
                    </tr>
                    <tr>
                      <th>Patient Mobile Number</th>
                      <td>013-9876543</td>
                      <th>Patient Address</th>
                      <td>Kampung Geliga, 24000 Chukai, Terengganu</td>
                    </tr>
                    <tr>
                      <th>Patient Gender</th>
                      <td>Male</td>
                      <th>Patient Age</th>
                      <td>45</td>
                    </tr>
                    <tr>
                      <th>Patient Medical History(if any)</th>
                      <td>Asma / Lelah ringan sejak kecil</td>
                      <th>Patient Reg Date</th>
                      <td>2026-05-10</td>
                    </tr>
                  </table>

                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <tr align="center">
                      <th colspan="8">Medical History</th> 
                    </tr>
                    <tr>
                      <th>#</th>
                      <th>Blood Pressure</th>
                      <th>Weight</th>
                      <th>Blood Sugar</th>
                      <th>Cholesterol</th>
                      <th>BMI</th>
                      <th>Date</th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>120 / 80</td>
                      <td>70 kg</td>
                      <td>5.4 mmol/L</td>
                      <td>4.2 mmol/L</td>
                      <td>22.8</td>
                      <td>2026-06-01</td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td>128 / 84</td>
                      <td>71.5 kg</td>
                      <td>5.6 mmol/L</td>
                      <td>4.5 mmol/L</td>
                      <td>23.3</td>
                      <td>2026-06-15</td>
                    </tr>
                  </table>
                  
                  <p align="center">            
                    <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Add overall Health Analysis</button>
                  </p>  

                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Health Analysis</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-bordered table-hover data-tables">
                            <form method="post" action="#">
                              <tr>
                                <th>Blood Pressure :</th>
                                <td><input name="bp" placeholder="Blood Pressure" class="form-control wd-450" required="true"></td>
                              </tr>     
                              <tr>
                                <th>Date :</th>
                                <td><input name="date" placeholder="Date" class="form-control datepicker" required="true" data-date-format="yyyy-mm-dd"></td>
                              </tr>                      
                              <tr>
                                <th>Blood Sugar :</th>
                                <td><input name="bs" placeholder="Blood Sugar" class="form-control wd-450" required="true"></td>
                              </tr> 
                              <tr>
                                <th>Weight :</th>
                                <td><input name="weight" placeholder="Weight" class="form-control wd-450" required="true"></td>
                              </tr>
                              <tr>
                                <th>BMI:</th>
                                <td><input name="bmi" placeholder="BMI" class="form-control wd-450" required="true"></td>
                              </tr>
                              <tr>
                                <th>Overall Summary :</th>
                                <td><textarea name="summary" placeholder="Insert your comment" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
                              </tr>   
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" onclick="alert('Demo: Analisis kesihatan berjaya dihantar!'); $('#myModal').modal('hide');">Submit</button>
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