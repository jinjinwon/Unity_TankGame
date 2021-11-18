<?php
	$u_id = $_POST[ "Input_user" ];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 

	$check = mysqli_query($con, "SELECT * FROM UserInfo WHERE UserNo= '". $u_id."'"	 );		

	$numrows = mysqli_num_rows($check);

	if($numrows == 0)
		die("ID does not exist. \n");

	$JSONResult = array();

	$row = mysqli_fetch_assoc($check); 
	if($row)
	{
		{
			//JSON 생성을 위한 변수
			$RowDatas = array();
			$JSONResult["UserInfo"] = array();

			$RowDatas["UserNo"] = $row["UserNo"];
			$RowDatas["UserId"] = $row["UserId"];
			$RowDatas["UserPw"] = $row["UserPw"];
			$RowDatas["UserNick"] = $row["UserNick"]; 		
			$RowDatas["UserGold"] = $row["UserGold"];
			$RowDatas["UserWin"] = $row["UserWin"];
			$RowDatas["UserDefeat"] = $row["UserDefeat"];

			array_push($JSONResult["UserInfo"], $RowDatas);
		}
	}

 	$sqlList = mysqli_query($con, "SELECT * FROM UserInfo ORDER BY UserWin DESC LIMIT 0, 10");
		
	$rowsCount = mysqli_num_rows($sqlList);

	$RowDatas = array();
	$JSONResult["Ranking"] = array();
	$JSONResult["Ranking"]["RkList"] = array();

	for($aa = 0; $aa < $rowsCount; $aa++)
	{
		$a_row = mysqli_fetch_array($sqlList);       //행 정보 가져오기
		if($a_row != false)
		{
			$RowDatas["UserNick"] = $a_row["UserNick"];      //한글 포함된 경우	
			$RowDatas["UserWin"] = $a_row["UserWin"];   	 //한글 포함된 경우
			$RowDatas["Ranking"] = $aa;
			array_push($JSONResult["Ranking"]["RkList"], $RowDatas); 
		}//if($a_row != false)
	}//for($aa = 0; $aa < $rowsCount; $aa++)

	$JSONResult["Ranking"]["RkCount"] = $rowsCount;

	$UserNocheck = mysqli_query($con, "SELECT * FROM UserItem WHERE UserId= '". $u_id."'"	 );

	$UserNonumrows = mysqli_num_rows($UserNocheck);

	if($UserNonumrows == 0)
	{
		die("UserId could not find. \n");
	}

	$RandomItemRowDatas = array();
	$JSONResult["RandomItem"] = array();

		for($ii = 0; $ii < $UserNonumrows; $ii++)
		{
			$a_row = mysqli_fetch_array($UserNocheck);
			if($a_row != false)
			{
			$RandomItemRowDatas["ItemNo"] = $a_row["ItemNo"];
			$RandomItemRowDatas["ItemName"] = $a_row["ItemName"];
			$RandomItemRowDatas["Level"] = $a_row["Level"];
			$RandomItemRowDatas["isBuy"] = $a_row["isBuy"];
			$RandomItemRowDatas["KindOfItem"] = $a_row["KindOfItem"];
			$RandomItemRowDatas["ItemUsable"] = $a_row["ItemUsable"];
			$RandomItemRowDatas["isAttack"] = $a_row["isAttack"];
			array_push($JSONResult["RandomItem"], $RandomItemRowDatas);
			}
		}

	$output = json_encode($JSONResult, JSON_UNESCAPED_UNICODE);	
	echo $output;
	echo ("\n");
	echo "JSONResult Pass Success";
	mysqli_close($con);
?>