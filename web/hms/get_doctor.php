<?php
include('include/config.php');
include('include/dbconfig.php');
if(!empty($_POST["specilizationid"])) 
{
  $special=$_POST["specilizationid"];
  $ref ="Doctor";
  $fetchdata=$database->getReference($ref)->getValue();
?>
 <option selected="selected">Select Doctor </option>
 <?php
 foreach($fetchdata as $key=> $row){	
   if($special==$row['Specialization'])	{?>
  <option value="<?php echo htmlentities($row['name']); ?>"><?php echo htmlentities($row['name']); ?></option>
  <?php
}
 }
}




?>

