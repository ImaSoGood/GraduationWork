<?php 

require_once '../Server/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$db = new DbOperation(); 
    $ids = $db->updateRequestss();
    echo "here";
    
    if($ids !== false || !empty($ids))
        $response['ids'] = $ids;
    else
    {
        $response['ids'] = "Nothing to see";
    }
}

echo json_encode($response);
?>