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
	<h1>Dashboard</h1>
    <p>Total number of distinct users: --</p>
    <p>Total number of test taken: --</p>
  <div class="row">
    <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Tests taken by category</h5>
        <canvas id="myChart" style="max-width:100%"></canvas>
      </div>
    </div>
    </div>
    <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Tests taken by month</h5>
        <canvas id="chart2" style="max-width:100%"></canvas>
      </div>
    </div>
    </div>
    <div class="col-sm-6">
    <div class="card">
      <canvas id="chart2" style="max-width:100%">Tests taken by month</canvas>
    </div>
    </div>
  </div>
</div>
<?php
  $db = new dbQueries();  

  /* Pie Chart - By Category */
  $category = $db->getByCategory();
  var_dump($category);
  $X_category = array(); $Y_category = array();
  foreach($category as $entry) {
	array_push($X_category, $entry['CatID']);
	array_push($Y_category, $entry['cnquesid']);
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
    'Red',
    'Blue',
    'Yellow'
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

var xValues = <?= $X_month; ?>;
var yValues = <?= $Y_month ?>;
var barColors = [
  'rgb(255, 99, 132)',
  'rgb(54, 162, 235)',
  'rgb(255, 205, 86)',
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("chart2", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "World Wide Wine Production 2018"
    }
  }
});
</script>


</body>
</html>
