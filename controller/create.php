<?php 
include '../model/database.php';

// data
$workName = $_POST['workName'];
$startingDay = $_POST['startingDay'];
$endingDay = $_POST['endingDay'];
$status = $_POST['status'];

// insert to table work
$table = 'work';
$data = [
	'work_name' => $workName,
	'starting_day' => $startingDay,
	'ending_day' => $endingDay,
	'status' => $status,
];

// new instance database
$db = new Database();

if($db->insert($table, $data)){
     echo $db->lastId($table);
}else {
    echo "Error: " .$db->error();
}

?>