<?php
error_reporting(0);
/* Database Functions for MySQL */

class DBWrapper {
function db_Connect() {
  $conn = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE, 3308);

  if (!$conn)
   die("Connection failed: " . mysqli_connect_error());
  else
   return $conn;
}

function db_Select($query) {
    $conn = $this->db_Connect();
    $result = mysqli_query($conn, $query) or die("Invalid Query: " . mysqli_error());
    mysqli_close();
	
	while ($row = mysqli_fetch_assoc($result)) {
        $sendArray[] = $row;
    }
   
    if (isset($sendArray)) return $sendArray;
    @mysqli_free_result($sendArray);
  }
 function db_RowCount($query) {
    $conn = $this->db_Connect();
    $result = mysqli_query($conn, $query) or die("Invalid Query: " . mysqli_error());
    mysqli_close();
	return mysqli_num_rows($result);
  }
 }
class dbQueries extends DBWrapper{
  function getQuestions($table, $quesid) {
	$sql = "SELECT * FROM `".$table."` WHERE `QuesID` = ".$quesid;
	return $this->db_Select($sql);
  }
  function getQuestionsId($userid, $testid, $catid) {
	echo $sql = "SELECT * FROM `questions` WHERE `QuesID` NOT IN (SELECT `QuesID` FROM `response` WHERE `UserID`=".$userid." AND `TestID`=".$testid.") AND `CatID`=".$catid." LIMIT 1";
	return $this->db_Select($sql);
  }
  function getAnswers($quesid) {
	$sql = "SELECT * FROM `answers` WHERE `QuesID` = ".$quesid;
	return $this->db_Select($sql);
  }
  function getCatQuestionId($catid) {
	$sql = "SELECT `QuesID` FROM `questions` WHERE `CatId` = ".$catid." LIMIT 1";
	$result = $this->db_Select($sql);
	return $result[0]['QuesID'];
  }
/*  function checkTest($custid, $testid) {		
 	$sql = "SELECT * FROM `response` WHERE `CustID` = '".$custid."' AND `TestID` = '".$testid."'";
 	return $this->db_RowCount($sql);
  } */
  function checkAnswer($quesid) {		
 	$sql = "SELECT `AnswerID` FROM `answers` WHERE `QuesID` = ".$quesid." AND `IsAnswer` = 1";
	$result = $this->db_Select($sql);
	return $result[0]['AnswerID'];
  }
  function getScore($custid) {
	$sql = "SELECT `Score` FROM `response` WHERE `TestID`=".$custid." ORDER BY `TestDate` DESC LIMIT 1";
	$result = $this->db_Select($sql);
	return $result[0]['Score'];
  }
  function insResponse($testid, $userid, $quesid, $answid, $score) {
	$sql = "INSERT INTO `response`(`TestID`, `UserID`, `TestDate`, `QuesID`, `AnswerID`, `IsCorrect`) VALUES ($testid, $userid, '".date('Y-m-d H:i:s')."', $quesid, $answid, $score)";
	return $this->db_Select($sql);
  }
/*  function updResponse($testid, $response, $score) {
	$sql = "UPDATE `response` SET `Response`=".$response.", `Score`=".$score." WHERE `TestID`=".$testid;
	return $this->db_Select($sql);
  } */
  function getNofUsers() {
	$sql = "SELECT COUNT(DISTINCT(`CustID`)) AS TotalUsers FROM `response`";
	return $this->db_Select($sql);
  }
  function getByCategory() {
	$sql = "SELECT count(response.QuesID) as `cnquesid`,questions.CatID FROM `response` INNER JOIN `questions` ON response.QuesID = questions.QuesID GROUP BY questions.CatID";
	return $this->db_Select($sql);
  }
  function getByMonth() {
	$sql = "SELECT DATE_FORMAT(`TestDate`, '%b %Y') AS dt, COUNT(*) AS ct FROM `response` GROUP BY MONTH(`TestDate`)";
	return $this->db_Select($sql);
  }
  function getByUser($testid) {
	 $sql = "SELECT response.UserID, count(response.UserID) AS ct,questions.CatID , count(questions.QuesID)   as percent FROM `response` 
inner JOIN questions on response.QuesID = questions.QuesID WHERE response.IsCorrect = 1 AND response.TestID =".$testid;
	return $this->db_Select($sql);
	}
}
class dbLogin extends DBWrapper{
  function getLogin($uname, $pwd) {
	$sql = "SELECT * FROM `users` WHERE `UserName` = '".$uname."' AND `Password` = '".$pwd."'";
	return $this->db_Select($sql);
  }
  function chkUser($uname) {
	$sql = "SELECT * FROM `users` WHERE `UserName` = '".$uname."'";
	return $this->db_Select($sql);
  }
  function setUser($uname, $pwd) {
	echo $sql = "INSERT INTO `users`(`UserName`, `Password`) VALUES ('".$uname."', '".$pwd."')";
	return $this->db_Select($sql);
  }
}
?>