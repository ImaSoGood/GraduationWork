<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$db = new DbOperation(); 
    $ids = $db->updateRequests();
    
    if($ids !== false || !empty($ids))
    {
        $response['ids'] = $ids;
        $db->sendNotificationsToUsers();
    }
    else
    {
        $response['ids'] = "Nothing to see";
    }
}

echo json_encode($response);
?>