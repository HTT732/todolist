<?php 
include '../model/database.php';

// data
$id = (int)$_POST['id'];

$table = 'work';

// new instance database
$db = new Database();

if ($db->delete($table, $id)) {
	echo true;
} else {
	echo "Error: " .$db->error();
}

?>
