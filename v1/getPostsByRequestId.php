<?php 
require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['text']))
    {
        $text = $_POST['text'];
        $command = '/var/www/u1059950/data/djangoenv/bin/python /var/www/u1059950/data/www/hub-24.online/Diplom/parser.py ' . $text;

        $output = array();
        exec($command, $output);
        
        if(!empty($output))
        {
            if(isset($_POST['request_id']))
	        {
		        $db = new DbOperation(); 
                $requests = $db->getPostsByRequestId($output, $_POST['request_id']);
        
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
    }
}

echo json_encode($response);
?>

