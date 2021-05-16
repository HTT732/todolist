<?php 
include '../model/database.php';

// data
$workName = $_POST['workName'];
$startingDay = $_POST['startingDay'];
$endingDay = $_POST['endingDay'];
$status = $_POST['status'];
$id = (int)$_POST['id'];

$table = 'work';
$data = [
	'work_name' => $workName,
	'starting_day' => $startingDay,
	'ending_day' => $endingDay,
	'status' => $status
];

// new instance database
$db = new Database();

if ($db->update($table, $data, $id)) {
	echo true;
} else {
	echo "Error: " .$db->error();
}

 ?>
