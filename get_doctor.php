<?php
include('include/config.php');
if(!empty($_POST["btypeid"])) 
{

 $sql=mysqli_query($con,"select engineer_Name,id from engineer where btype='".$_POST['btypeid']."'");?>
 <option selected="selected">Select Engineer </option>
 <?php
 while($row=mysqli_fetch_array($sql))
 	{?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['engineer_Name']); ?></option>
  <?php
}
}


if(!empty($_POST["engineer"])) 
{

 $sql=mysqli_query($con,"select no_of_workers from engineer where id='".$_POST['engineer']."'");
 while($row=mysqli_fetch_array($sql))
 	{?>
 <option value="<?php echo htmlentities($row['no_of_workers']); ?>"><?php echo htmlentities($row['no_of_workers']); ?></option>
  <?php
}
}

?>

