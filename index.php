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
  include(__DIR__."/inc/beans.inc");  
  session_start();
  ?>
</head>

<body>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-4">
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h4>Login</h4>
    <?php if (isset($_GET['error'])) { ?>
      <p class="error form-control is-invalid"><?php echo $_GET['error']; ?></p>
      <?php } ?>
    <div class="input-group mb-3"> <span class="input-group-text">
      <label class="form-label">User Name</label>
      </span>
      <input type="text" name="uname" class="form-control">
    </div>
    <div class="input-group mb-3"> <span class="input-group-text">
      <label class="form-label">Password</label>
      </span>
      <input type="password" name="password" class="form-control">
      <br>
    </div>
    <button name="btnLogin" type="submit" class="btn btn-outline-primary">Login</button>
  </form>
   </div>
   
    <div class="col-4">
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h4>Register</h4>
    <?php if (isset($_GET['regerror'])) { ?>
      <p class="error form-control is-invalid"><?php echo $_GET['regerror']; ?></p>
      <?php } ?>
    <div class="input-group mb-3"> <span class="input-group-text">
      <label class="form-label">User Name</label>
      </span>
      <input type="text" name="newuname" class="form-control">
    </div>
    <div class="input-group mb-3"> <span class="input-group-text">
      <label class="form-label">Password</label>
      </span>
      <input type="newpwd" name="newpwd" class="form-control">
      <br>
    </div>
    <button name="btnReg" type="submit" class="btn btn-outline-primary">Register</button>
  </form>
   </div>
   
  </div>
  <?php    
  if (isset($_POST['btnLogin']) && isset($_POST['uname']) && isset($_POST['password'])) {
    $db = new dbLogin();
	$uname = validateInput($_POST['uname']);
    $pwd = validateInput($_POST['password']);
	if (empty($uname)) {
	  $error = "User Name is required";
      header("Location: index.php?error=User Name is required");
      exit();
    } else if(empty($pwd)){
	  $error = "Password is required";
	  header("Location: index.php?error=Password is required");
	  exit();
    } else{
	  $login = $db->getLogin($uname, $pwd);
	  
	  if($uname=="admin") {
	    header("Location: dashboard.php");		  
	  }
	  else if (empty($login)) {
	    header("Location: index.php?error=User Name/Password is incorrect");	
	  }
	  else {
	    $_SESSION['userid'] = $login[0]['UserId'];;
	    header("Location: welcome.php");
	  }
    }
  }
  
   if (isset($_POST['btnReg']) && isset($_POST['newuname']) && isset($_POST['newpwd'])) {
    $db = new dbLogin();
	$uname2 = validateInput($_POST['newuname']);
    $pwd2 = validateInput($_POST['newpwd']);
	if (empty($uname2)) {
	  $error = "User Name is required";
      header("Location: index.php?regerror=User Name is required");
      exit();
    } else if(empty($pwd2)){
	  $error = "Password is required";
	  header("Location: index.php?regerror=Password is required");
	  exit();
    } else{
	  $chk = $db->chkUser($uname2);
	  if (!empty($chk)) {
	    header("Location: index.php?regerror=User Name already exists");	
	  }
	  else if($uname2=="admin") {
	    header("Location: index.php?regerror=Cannot use admin registration");
	  }
	  else {
	    $db->setUser($uname2, $pwd2);
		$login = $db->getLogin($uname2, $pwd2);
	    $_SESSION['userid'] = $login[0]['UserId'];
	    header("Location: welcome.php");
	  }
	}
}
?>
</div>
</body>
</html>
