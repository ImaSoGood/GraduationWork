<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['user_id']))
	{
		$db = new DbOperation(); 
        $posts = $db->getNewPosts($_POST['user_id']);
        
		if($posts !== false)
		{
		    $response['message'] = "New posts";
			$response['error'] = false; 
			$response['posts'] = $posts;
		}
		else
		{
			$response['error'] = true;
			$response['message'] = "NoNew";			
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

