<?php
	$User_id = $_POST["U_ID"];
	
	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	// "localhost" <-- 같은 서버 내

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error()); 
	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻	

	//$check = mysqli_query($con, "SELECT * FROM UserItem AS Uid JOIN TestAttItem AS Aid On Aid.No = '".$Item_No."' Where Uid.UserId = '".$User_id."'");
	$check = mysqli_query($con, "SELECT Aid.No,Aid.UnitName,Aid.UnitAttack,Aid.UnitDefence,Aid.UnitHP,Aid.UnitAttSpeed,Aid.UnitMoveSpeed,Aid.UnitMoveSpeed,Aid.UnitPrice,Aid.UnitUpPrice,Aid.UnitUseable,Aid.UnitKind,Aid.UnitRange 
FROM UserItem AS Uid JOIN AttItem AS Aid On Aid.No = Uid.ItemNo Where Uid.UserId = '".$User_id."'");
	
	$numrows = mysqli_num_rows($check);
	if($numrows == 0)
	{  //mysqli_num_rows() 함수는 데이터베이스에서 쿼리를 보내서 나온 레코드의 개수를 알아낼 때 쓰임
	   //즉 0이라는 뜻은 해당 조건을 못 찾았다는 뜻
		
		die("ID Does Exist.");
	}
	
	$RowDatas = array();
	$Return = array();
	$RowDatas["Count"] = $numrows;
	for($i = 0; $i < $numrows; $i++)
	{
		$a_row = mysqli_fetch_array($check);
		if($a_row != false)
		{
			$RowDatas["No"][$i] = $a_row["No"];		
			$RowDatas["UnitName"][$i] = $a_row["UnitName"];
			$RowDatas["UnitAttack"][$i] = $a_row["UnitAttack"];
			$RowDatas["UnitDefence"][$i] = $a_row["UnitDefence"];
			$RowDatas["UnitHP"][$i] = $a_row["UnitHP"];
			$RowDatas["UnitAttSpeed"][$i] = $a_row["UnitAttSpeed"];
			$RowDatas["UnitMoveSpeed"][$i] = $a_row["UnitMoveSpeed"];
			$RowDatas["UnitPrice"][$i] = $a_row["UnitPrice"];
			$RowDatas["UnitUpPrice"][$i] = $a_row["UnitUpPrice"];
			$RowDatas["UnitUseable"][$i] = $a_row["UnitUseable"];
			$RowDatas["UnitKind"][$i] = $a_row["UnitKind"];
			$RowDatas["UnitRange"][$i] = $a_row["UnitRange"];
		}
	}
	array_push($Return, $RowDatas);
	
	$JSONBUFF["UnitList"] = $Return;
	$output = json_encode($JSONBUFF, JSON_UNESCAPED_UNICODE);
	echo $output;
	echo "Load-Success";
	// if($row)
	// {	
		// $a_row = mysqli_fetch_array($check);

		// // JSON 생성을 위한 변수
		// $RowDatas = array();
		// $RowDatas["No"] = $row["No"];		
		// $RowDatas["UnitName"] = $row["UnitName"];
		// $RowDatas["UnitAttack"] = $row["UnitAttack"];
		// $RowDatas["UnitDefence"] = $row["UnitDefence"];
		// $RowDatas["UnitHP"] = $row["UnitHP"];
		// $RowDatas["UnitAttSpeed"] = $row["UnitAttSpeed"];
		// $RowDatas["UnitMoveSpeed"] = $row["UnitMoveSpeed"];
		// $RowDatas["UnitPrice"] = $row["UnitPrice"];
		// $RowDatas["UnitUpPrice"] = $row["UnitUpPrice"];
		// $RowDatas["UnitUseable"] = $row["UnitUseable"];
		// $RowDatas["UnitKind"] = $row["UnitKind"];
		// $RowDatas["UnitRange"] = $row["UnitRange"];

		// $output = json_encode($RowDatas,JSON_UNESCAPED_UNICODE);

		// // 출력
		// echo $output;
		// echo "<br>";
		// echo "Load-Success"; 
	// }

	mysqli_close($con);
?>