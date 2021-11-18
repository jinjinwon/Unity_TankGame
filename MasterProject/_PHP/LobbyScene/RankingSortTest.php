<?php	
	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	// "localhost" <-- 같은 서버 내

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 

	$JSONBUFF = array(); 

	//---------------------------- 10위안 리스트 JSON형식으로 만들기...
 	$sqlList = mysqli_query($con, "SELECT * FROM UserInfo ORDER BY UserWin DESC LIMIT 0, 10");
	//0에서부터 10명까지만...
	//* <-- 해당 행의 모든 컬럼(COLUMN)을 가져오라는 뜻 
	//(특정 컬럼(COLUMN)들만 선택적으로 가져올 수 있다. 쉼표로 구분해서...)
	//정렬 옵션
	//오름차순(ASC) : 작은 값부터 큰 값 쪽으로의 순서 ex)1, 2, 3, 4, 
	//내림차순(DESC) : 큰 값부터 작은 값 쪽으로의 순서 ex)5, 4, 3, 2, 1
		
	$rowsCount = mysqli_num_rows($sqlList);
	echo $rowsCount."<br>";

	if (!$sqlList || $rowsCount == 0)
	{
		die("List does not exist. \n");
	}

	$RowDatas = array();
	$Return   = array();

	for($aa = 0; $aa < $rowsCount; $aa++)
	{
		$a_row = mysqli_fetch_array($sqlList);       //행 정보 가져오기
		if($a_row != false)
		{
			//JSON 생성을 위한 변수		
			$RowDatas["UserNick"]   = $a_row["UserNick"];      //한글 포함된 경우	
			$RowDatas["UserWin"] = $a_row["UserWin"];  //한글 포함된 경우
			$RowDatas["Ranking"] = $aa;
			array_push($Return, $RowDatas); 
			//JSON 데이터 생성을 위한 배열에 레코드 값 추가
		}//if($a_row != false)
	}//for($aa = 0; $aa < $rowsCount; $aa++)

	$JSONBUFF['RkList'] = $Return;   //배열 이름에 배열에 넣기
	$JSONBUFF['RkCount'] = $rowsCount;
	//---------------------------- 10위안 리스트 JSON형식으로 만들기...
	
	//---------------------------- 자신의 랭킹 순위 찾아오기...
	//그룹화하여 데이터 조회 (GROUP BY) https://extbrain.tistory.com/56

	//http://cremazer.blogspot.com/2013/09/mysql-rownum.html : 참고함(1번방법)
	//https://wedul.site/434  //https://link2me.tistory.com/536  //https://lightblog.tistory.com/190 //<--장단점
	//변수는 앞에 @을 붙인다.
	//변수에 값을 할당시 set, select로 할 수 있다. 할당시에는 := 로 한다. 
	mysqli_query($con, "SET @curRank := 0"); //(MY SQL 내에서 사용할 변수 선언법) 변수 사용은 새션내에서만 유효합니다.
	//$check = mysqli_query($con, "SELECT user_id, myrankidx 
          	//      		FROM (SELECT user_id, 
            //  	    		@curRank := @curRank + 1 as myrankidx 
            //    		    	FROM MyDBStudy 
	//			ORDER BY best_score DESC) as CNT 
	//  	      	WHERE `user_id`='".$u_id."'");

	//as 는 변수의 별칭을 만들어서 사용하겠다는 뜻(형변환과 비슷)  			
	// https://recoveryman.tistory.com/172

	//$numrows = mysqli_num_rows($check);
	//if (!$check || $numrows == 0)
	//{
	//	die("Ranking search failed for ID. \n");
	//}

	//if($row = mysqli_fetch_assoc($check)) //찾은 user_id 이름에 해당하는 행을 하나만 가져오기 <연관 배열 가져오기 : 키값배열>
	{	  
		//JSON 파일 생성
	//	$JSONBUFF["my_rank"]   = $row["myrankidx"];   
		//header("Content-type:application/json"); //생략
		$output = json_encode($JSONBUFF, JSON_UNESCAPED_UNICODE); //한글 포함된 경우
		echo $output;
		echo ("\n");
		echo "Get_Rank_list_Success~";
	}//if($row = mysql_fetch_assoc($check))
	//---------------------------- 자신의 랭킹 순위 찾아오기...
?>