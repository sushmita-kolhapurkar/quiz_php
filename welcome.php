<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<link href="style.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<?php
  include(__DIR__."/inc/env-properties.inc");
  include(__DIR__."/inc/db.inc.php");  
  session_start();
  ?>
</head>

<body>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
    	<h4>Welcome To The Fun Quiz!</h4>
        
        <p>This will take just a few minutes. <br />
        Quick and simple - It takes just one click per question.
        So think before you select an option!</p>
        
        <p>So... Let's get started</p>
  		<form action="quiz.php" method="post">
          <button name="start" type="submit" class="btn btn-outline-primary">Start ----></button>
        </form>
    </div>
  </div>
</div>

</body>
</html>
