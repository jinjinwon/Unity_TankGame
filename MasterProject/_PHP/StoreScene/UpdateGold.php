<?php
	$u_ID  = $_POST["Input_ID"]; 
	$u_Gold = $_POST["Input_Gold"];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 

	$check = mysqli_query($con, "SELECT * FROM UserInfo WHERE UserId = '".$u_ID."'" );
	$numrows = mysqli_num_rows($check);
	if($numrows == 0) 
	{
		die("ID does exist. \n");
	}

	$check = mysqli_query($con, "UPDATE UserInfo SET UserGold='".$u_Gold."' WHERE UserId='".$u_ID."'" );
	
	if($check)
	{
		echo("UpdateGoldSuccess");
	}
	else
	{
		echo("Fail");
	}
	
	mysqli_close($con);

?>