<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$db = new DbOperation(); 
    $db->sendNotificationsToUsers();

}
?>