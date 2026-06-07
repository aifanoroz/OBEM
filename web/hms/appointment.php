<?php
session_start();
error_reporting(0);
include('include/checklogin.php');
include('./include/dbconfig.php');
check_login();
if(isset($_GET['cancel']))
		  {
			$uid=$_GET['id'];
			$dstatus=0;
			
	$doctor=[
	'doctorStatus'=>$dstatus
	];
// ! for appointment update
	$ref="Appointment/$uid/";
	$pushdata =$database->getReference($ref)->update($doctor);

	// ! for appointment history
$ref ="Appointment";
$fetchdata=$database->getReference($ref)->getValue();
foreach($fetchdata as $key=> $row){		
	$id=$row['uid'];
	if($id==$uid){
	$Username=$row['Username'];
	$Docname=$row['Docname'];
	$specialization=$row['specialization'];
	$date=$row['date'];
	$time=$row['time'];
	$key=$row['key'];
	break;
	}

										}
$appointment=[
		'Docname'=>$Docname,
		'Username'=>$Username,
		'date'=>$date,
		'doctorStatus'=>$dstatus,
	   'specialization'=>$specilization,
		'time'=>$time,
		'uid'=>$vid,
		'key'=>$key
											];									
	
	$ref2="AppointmentHistory/$uid/$date";
$pushdata2 =$database->getReference($ref2)->set($appointment);
if($pushdata)
{
	echo "<script>alert('Appointment Cancelled');</script>";
	echo "<script>window.location.href ='appointment.php'</script>";
}
else
  {
	echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }
}
elseif(isset($_GET['attend'])){
				$uid=$_GET['id'];
			$dstatus=2;
			
	$doctor=[
	'doctorStatus'=>$dstatus
	];
// ! for appointment update
	$ref="Appointment/$uid/";
	$pushdata =$database->getReference($ref)->update($doctor);

	// ! for appointment history
$ref ="Appointment";
$fetchdata=$database->getReference($ref)->getValue();
foreach($fetchdata as $key=> $row){		

	$id=$row['uid'];
	if($id==$uid){
	$Username=$row['Username'];
	$Docname=$row['Docname'];
	$specialization=$row['specialization'];
	$date=$row['date'];
	$time=$row['time'];
	$key=$row['key'];
	break;
	}
										}
$appointment=[
	
	'Docname'=>$Docname,
											'Username'=>$Username,
											'date'=>$date,
											'doctorStatus'=>$dstatus,
											'specialization'=>$specilization,
											'time'=>$time,
											'uid'=>$vid,
											'key'=>$key
											];									
	
	$ref2="AppointmentHistory/$uid/$date";
$pushdata2 =$database->getReference($ref2)->set($appointment);
if($pushdata)
{
	echo "<script>alert('Appointment Mark As Attended');</script>";
	echo "<script>window.location.href ='appointment.php'</script>";
}
else
  {
	echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }

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
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Nurse  | Appointment </h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>Nurse   </span>
									</li>
									<li class="active">
										<span>Appointment</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
						

									<div class="row">
								<div class="col-md-12">
									
									<p style="color:red;"><?php echo htmlentities($_SESSION['msg']);?>
								<?php echo htmlentities($_SESSION['msg']="");?></p>	
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
$ref ="Appointment";
$fetchdata=$database->getReference($ref)->getValue();
$cnt=1;
foreach($fetchdata as $key=> $row){		
?>

											<tr>
												<td class="center"><?php echo $cnt;?>.</td>
												<td class="hidden-xs"><?php echo $row['Username'];?></td>
												<td><?php echo $row['Docname'];?></td>
												<td><?php echo $row['specialization'];?></td>
												<td><?php echo $row['date'];?></td>
												<td><?php echo $row['time'];?></td>
												<td>
<?php if( ($row['doctorStatus']==1))  
{
	echo "Active";
}
if(($row['doctorStatus']==2))  
{
	echo "Completed";
}

if( ($row['doctorStatus']==0))  
{
	echo "Cancel by you";
}



												?></td>
												<td >
												<div class="visible-md visible-lg hidden-sm hidden-xs">
												<?php if(($row['doctorStatus']==1))  
{ ?>

													
<a href="appointment.php?id=<?php echo $row['uid']?>&attend=update" onClick="return confirm('Are you sure you want to mark this appointment as attended ?')"class="btn btn-transparent btn-xs tooltips" title="Mark as Attended" tooltip-placement="top" tooltip="Remove"><i class="fa fa-check"></i></a>||<a href="appointment.php?id=<?php echo $row['uid']?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment ?')"class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><i class="fa fa-ban"></i></a>
	<?php } elseif(($row['doctorStatus']==2)){

echo "Mark Attended";
} 
	 else{

echo "Cancelled";
} 
?>
											</td>
											</tr>
											
											<?php 
$cnt=$cnt+1;
											 }?>
											
											
										</tbody>
									</table>
								</div>
							</div>
								</div>
						
						<!-- end: BASIC EXAMPLE -->
						<!-- end: SELECT BOXES -->
						
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
			
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
