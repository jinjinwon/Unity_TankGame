<?php
	$u_number = $_POST["Input_usernumber"];
	$maplist = json_decode($_POST["map_list"], true);
	$mapnumber = array();
	$checkmap = 0;
	$ii = 0;
	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	if(!$con)	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻
		die("Could not Connect".mysqli_connect_error());

	$result = mysqli_query($con, "SELECT mapN FROM MapSetting WHERE userN = '".$u_number."'");
	if($result > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$mapnumber[$ii] = $row["mapN"];
			$ii++;
		}
		$checkmap = $ii;
	}

	for($i = 0; $i < 3; $i++)
	{
		$OutPutMap = $maplist["MapType"][$i];
		$OutPutSpawn = $maplist["UserSellSpawn"][$i];
		$OutPutTower = $maplist["USerSellTower"][$i];
		$OutPutMapPower = $maplist["USerMapPower"][$i];
		echo $OutPutMapPower." : ";
		if($checkmap > 0)
		{
			mysqli_query($con, "INSERT INTO `MapSetting` (`mapN`,`mapType`,`userN`,`userSetTower`,`towerType`,`mapPower`) VALUES('".$mapnumber[$i]."', '".$OutPutMap."','".$u_number."','".$OutPutSpawn."','".$OutPutTower."','".$OutPutMapPower."') ON DUPLICATE KEY UPDATE `userSetTower` ='".$OutPutSpawn."', `towerType` ='".$OutPutTower."', `mapPower` ='".$OutPutMapPower."'");  
			echo "if";
		}
		else
		{ 
			mysqli_query($con, "INSERT INTO `MapSetting` (`mapType`,`userN`,`userSetTower`,`towerType`,`mapPower`) VALUES('".$OutPutMap."','".$u_number."','".$OutPutSpawn."','".$OutPutTower."','".$OutPutMapPower."') ON DUPLICATE KEY UPDATE `userSetTower` ='".$OutPutSpawn."', `towerType` ='".$OutPutTower."', `mapPower` ='".$OutPutMapPower."'");  
			echo "else";
		}
	
	}
	
	echo (" : MapSaveDone");

	mysqli_close($con);
?>