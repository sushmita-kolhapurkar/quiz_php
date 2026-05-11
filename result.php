<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<?php
  include(__DIR__."/inc/env-properties.inc");
  include(__DIR__."/inc/db.inc.php");  
  session_start();
  ?>
</head>

<body>
<div class="container-fluid">
	<h1>Result</h1>
  <div class="row">
    <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Number of correct answers by category</h5>
        <canvas id="myChart" style="max-width:100%"></canvas>
      </div>
    </div>
    </div>
  </div>
</div>
<?php
  $db = new dbQueries();  
	$testid = $_SESSION['testid'];

  /* Pie Chart - By Category */
  $category = $db->getByUser($testid);
  $X_category = array(); $Y_category = array();
  foreach($category as $entry) {
	array_push($X_category, $entry['CatID']);
	array_push($Y_category, $entry['ct']);
  }
  $X_Category = json_encode($X_Category);
  $Y_category = json_encode($Y_category);

  /* Bar Chart - By Month */
  $month = $db->getByMonth();
  $X_month = array(); $Y_month = array();
  foreach($month as $entry) {
	array_push($X_month, $entry['dt']);
	array_push($Y_month, $entry['ct']);
  }
  $X_month = json_encode($X_month);
  $Y_month = json_encode($Y_month);
  

?>
<script>
var xValues = <?= $X_Category; ?>;
var yValues = <?= $Y_category ?>;
var barColors = [
  'rgb(255, 99, 132)',
  'rgb(54, 162, 235)',
  'rgb(255, 205, 86)',
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: [
    'Cartoon',
    'Movies',
    'Geography'
  ],
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Tests taken by category"
    }
  }
});
</script>


</body>
</html>
