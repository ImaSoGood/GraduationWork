<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['id']))
	{
		$db = new DbOperation(); 
        $ad = $db->addRequestAlwaysUpdate($_POST['id']);
        
        $response['error'] = false; 
		$response['always_update'] = $ad;
	}
	else
	{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);
?>

