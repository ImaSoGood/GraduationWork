<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['user_id']))
	{
		$db = new DbOperation(); 
        $requests = $db->getUserRequests($_POST['user_id']);
        
        if(!empty($requests))
        {
            $response['error'] = false; 
		    $response['requests'] = $requests;
        }
        else
        {
            $response['error'] = true; 
		    $response['message'] = "No requests";
        }
	}
	else
	{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);
?>

