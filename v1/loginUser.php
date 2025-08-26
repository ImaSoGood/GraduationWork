<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['login']) && isset($_POST['password']))
	{
		$db = new DbOperation(); 
        $id = $db->loginUser($_POST['login'], $_POST['password']);
        
		if($id !== -1 && $id !== false)
		{
		    $response['message'] = "";
			$response['error'] = false; 
			$response['id'] = $id;
		}
		else
		{
			$response['error'] = true;
			$response['code'] = -10;
			$response['message'] = "Invalid username or password";			
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

