<?php
	$u_No = $_POST[ "Input_No" ]; 

	//echo $u_id."<br>";
	//echo $u_pw."<br>";

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	// "localhost" <-- 같은 서버 내

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 
	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻
	

	// 유저 아이템 데이터 받아오는 부분
	$sqlList = mysqli_query($con, "Select u.ItemNo, u.ItemName, u.Level, u.isBuy, u.KindOfItem, u.ItemUsable, u.isAttack, i.UnitAttack, i.UnitDefence, i.UnitHP, i.UnitAttSpeed, i.UnitMoveSpeed, i.UnitPrice,i.UnitUpPrice,i.UnitRange, i.UnitSkill from UserItem AS u JOIN AttItem AS i on u.KindOfItem = i.No and u.isAttack = 1 and u.UserId = '".$u_No."'");

	$rowsCount = mysqli_num_rows($sqlList);
	if($rowsCount == 0|| !$sqlList)
	{
		mysqli_close($con);
		die("Item List does not exist. \n");
	}
	
	$ItemRowDatas = array();
	$ItemInfos = array();
	
	// 1차적으로 Select 하는 부분
	for($aa = 0; $aa < $rowsCount; $aa++)
	{
		$a_row = mysqli_fetch_array($sqlList);
		if($a_row != false)
		{
			//JSON 생성을 위한 변수
			$ItemRowDatas["ItemNo"] = $a_row["ItemNo"];
			$ItemRowDatas["ItemName"] = $a_row["ItemName"];
			$ItemRowDatas["Level"] = $a_row["Level"];
			$ItemRowDatas["isBuy"] = $a_row["isBuy"];
			$ItemRowDatas["KindOfItem"] = $a_row["KindOfItem"];
			$ItemRowDatas["ItemUsable"] = $a_row["ItemUsable"];
			$ItemRowDatas["isAttack"] = $a_row["isAttack"];
			$ItemRowDatas["UnitAttack"] = $a_row["UnitAttack"];
			$ItemRowDatas["UnitDefence"] = $a_row["UnitDefence"];
			$ItemRowDatas["UnitHP"] = $a_row["UnitHP"];
			$ItemRowDatas["UnitAttSpeed"] = $a_row["UnitAttSpeed"];
			$ItemRowDatas["UnitMoveSpeed"] = $a_row["UnitMoveSpeed"];
			$ItemRowDatas["UnitPrice"] = $a_row["UnitPrice"];
			$ItemRowDatas["UnitUpPrice"] = $a_row["UnitUpPrice"];					
			$ItemRowDatas["UnitRange"] = $a_row["UnitRange"];				
			$ItemRowDatas["UnitSkill"] = $a_row["UnitSkill"];		
			array_push($ItemInfos, $ItemRowDatas);
		}//if($a_row != false)
	}//for($aa = 0; $aa < $rowsCount; $aa++)
	
	$JSONBUFF["UnitList"] = $ItemInfos;
	$output = json_encode($JSONBUFF,JSON_UNESCAPED_UNICODE);
	echo $output;
	echo "\n";
	echo "Get_Item_Success~";
	
	mysqli_close($con);
?>