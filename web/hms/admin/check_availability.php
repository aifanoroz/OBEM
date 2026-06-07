<?php 
include('../include/dbconfig.php');
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	$ref ="Doctor";
	$fetchdata=$database->getReference($ref)->getValue();
	foreach((array) $fetchdata as $key=> $row)
	{
		$email2=$row['docEmail'];

		if($email==$email2){
			echo "<span style='color:red'> Email already exists .</span>";
			 echo "<script>$('#submit').prop('disabled',true);</script>";
			 break;
			} else{
				echo "<script>$('#submit').prop('disabled',false);</script>";
			}

	}
}
?>
