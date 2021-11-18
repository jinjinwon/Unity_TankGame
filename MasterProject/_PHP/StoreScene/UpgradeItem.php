<?php
	$u_ItemName = $_POST["Input_ItemName"];
	$u_Level = $_POST["Input_Level"];
	$u_ID = $_POST["Input_ID"];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	
	if(!$con)
		die("Could not Connect" . mysqli_connect_error()); 

	$check = mysqli_query($con, "UPDATE UserItem SET Level='".$u_Level."' WHERE UserId='".$u_ID."' and ItemName='".$u_ItemName."'");
	
	if($check)
	{
		echo("Success");
		// °ñµå°ª 
	}
	else
	{
		echo("Fail");
	}
	
	mysqli_close($con);
?>