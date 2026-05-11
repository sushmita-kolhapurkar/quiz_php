<?php 
/* Generate a random number */
function generateRand($start, $end, $existing_no)
{
  $new_no = rand($start, $end);
  $new_no = ($new_no == $catid) ? random($new_no) : $new_no;
  return $new_no;
}
function validateInput($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }

?>