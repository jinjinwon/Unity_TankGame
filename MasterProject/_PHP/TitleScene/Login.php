<?php
	$u_id = $_POST[ "Input_user" ]; 
	$u_pw = $_POST[ "Input_pass" ];

	//echo $u_id."<br>";
	//echo $u_pw."<br>";

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	// "localhost" <-- 같은 서버 내

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 
	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻
	
	//유저의 기본 정보 받아오는 부분
	$check = mysqli_query($con, "SELECT * FROM UserInfo WHERE UserId = '". $u_id ."'" );	
	$numrows = mysqli_num_rows($check);
	if($numrows == 0)
	{  //mysqli_num_rows() 함수는 데이터베이스에서 쿼리를 보내서 나온 레코드의 개수를 알아낼 때 쓰임
	   //즉 0이라는 뜻은 해당 조건을 못 찾았다는 뜻

		die("ID does not exist. \n");
	}

	$row = mysqli_fetch_assoc($check); //user_id 이름에 해당하는 행의 내용을 가져온다.
	if($row)
	{
		if($u_pw == $row["UserPw"])
		{
			//JSON 생성을 위한 변수
			$RowDatas = array();
			$RowDatas["UserId"] = $row["UserId"]; //한글 포함된 경우		
			$RowDatas["UserNo"] = $row["UserNo"];
			$u_No = $row["UserNo"];	// 아래 검색을 위한 넘버
			$RowDatas["UserNick"] = $row["UserNick"];
			$RowDatas["UserGold"] = $row["UserGold"];
			$RowDatas["UserWin"] = $row["UserWin"];
			$RowDatas["UserDefeat"] = $row["UserDefeat"];
			$LoginInfo = json_encode($RowDatas, JSON_UNESCAPED_UNICODE);	//PHP 5.4 이상 버전에서 한글 않깨지게..
			//JSON 파일 생성	
	
			//출력
			echo $LoginInfo;
			echo "\n";
			echo "Login-Success!!";
		}
		else
		{
			die("Pass does not Match. \n");
		}
	}
	
	mysqli_close($con);
?>