<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quiz</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link href="style.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<?php
  include(__DIR__."/inc/env-properties.inc");
  include(__DIR__."/inc/db.inc.php");  
  include(__DIR__."/inc/beans.inc");  
  session_start();
  ?>
</head>

<body>
<?php
 //add customer id session
  $userid = $_SESSION['userid'];
  ?>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
        <?php
  $db = new dbQueries();
  if(!isset($_POST['btnOption'])) {
	$quesid = $_SESSION['quesid'] = 1;
	$catid = $_SESSION['catid'] = 1;
	$testid = $_SESSION['testid'] = generateRand(1, 200, 0);
	$count = $_SESSION['count'] = 1;
  }
  else {
	$quesid = $_SESSION['quesid'];
	$selection = $_POST['btnOption'];
	$catid = $_SESSION['catid'];
	$testid = $_SESSION['testid'];
	$count = $_SESSION['count'];
	
	/* Check if Response is correct */
	$answer = $db->checkAnswer($quesid);
	
	if ($selection == $answer['Answer']) {
		$score = 1;
	}
	else {
		$score = 0;	
	 	$catid = generateRand(1, 3, $catid);
	}
	/* Insert/Update Response details */
	$db->insResponse($testid, $userid, $quesid, $selection, $score);
  }
  
  if ($count <=10) {
	$question = $db->getQuestionsId($userid, $testid, $catid);
	$options = $db->getAnswers($question[0]['QuesID']);
	$_SESSION['quesid'] = $question[0]['QuesID']; //set new question id
	$count++;
	$_SESSION['count'] = $count;
  }
  else {
	header("Location: result.php");
  }
	
 ?>
        <div class="card">
          <div class='card-body'>
            <h5 class='card-title'>
              <?= $question[0]['Question'] ?>
            </h5>
          </div>
          <div class='list-group list-group-flush'>
            <?php
				
	  foreach($options as $key=>$opt) {
        echo "<button name='btnOption' type='submit' class='btnOption list-group-item text-start' value=".$opt['AnswerID'].">".$opt['Options']."</button>";
	  }
  	  echo "</div>";
?>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
