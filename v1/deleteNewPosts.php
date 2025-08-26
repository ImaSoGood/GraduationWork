<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['request_id']))
	{
		$db = new DbOperation(); 
        $db->deleteFromNewPosts($_POST['request_id']);
	}
	else
	{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);
?>

