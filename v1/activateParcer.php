<?php 
require_once '../Server/DbOperations.php';

$response = array(); //addUserRequest

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['text']) && isset($_POST['user_id']))
    {
        
        $text = $_POST['text'];
        $command = '/var/www/u1059950/data/djangoenv/bin/python /var/www/u1059950/data/www/hub-24.online/Diplom/parser.py ' . $text;

        $output = array();
        exec($command, $output);
        
        if(!empty($output))
        {
            /*foreach($output as $line)
            {
                echo $line."</br>";
            }*/
            
            $db = new DbOperation();
            $id = $db->addUserRequest($_POST['user_id'], $_POST['text'], date('Y-m-d H:i:s'));
            
            if($id !== false)
            {
                $ids = $db->parceMnogotovarovJson($output, $_POST['user_id'], $id);
                
                if($ids !== false)
                {
                    $result = $db->getPostsByIds($ids);
                    echo json_encode($result);
                }
            }
        }
        else
        {
            $response['error'] = true;
            $response['message'] = "No items";
            echo json_encode($response);
        }
    }
    else
    {
        $response['error'] = true;
        $response['message'] = "No text parameter provided";
        echo json_encode($response);
    }
}
else
{
    $response['error'] = true;
    $response['message'] = "Some error occured";
    echo json_encode($response);
}
?>