<?php

class DbOperation
{
    private $response = array(); 
    private $con;
    
    function __construct()
    {
        require_once dirname(__FILE__).'/DbConnect.php';//getUserWorkTypesArray//DbOperations.php
		$db = new DbConnect();

		$this->con = $db->connect(); 
    }
    
    private function closeStmt($stmt) 
    {
        $stmt->close();
    }
    
    
    public function loginUser($logData, $password)
    {
        $password = md5($password);
        
        $stmt = $this->con->prepare("SELECT id FROM Users WHERE login = ? AND password = ?");
        $stmt->bind_param("ss", $logData, $password);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0)
        {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();
            return $id;
        } 
        else 
        {
            $stmt->close();
            return -1;
        }
    }
	
    public function createUser($login, $password, $token)
    {
        if($this->isLoginExist($login) > 0)
        {
            return 0;
        }
        else
        {
            $password = md5($password);
            $stmt = $this->con->prepare("INSERT INTO Users(password, login, token) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $password, $login, $token);
            
            if($stmt->execute())
            {
                $this->closeStmt($stmt);
                $user_id = $this->returnId($login, $password);
                
                return $user_id; 
            }
            else
            {
                $this->closeStmt($stmt); 
                return -100; 
            }
        }
    }
    
    
    
    public function sendNotification($deviceToken)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/diplom-b6ee0/messages:send';

        $headers = array
        (
            //'Authorization: key=AAAAVtLzq1I:APA91bGTAMvtUbyylnVVrfWJrTzVB6VEWMhFCEcPubcTw73d_8ZYdgXvsctjstNIcWn5wrSFNmZkQ2ElOOBgiNAPAXfJWlooHOqQiKLsvP2jN2EMTes7M0JsFwKn_KAgfHWRUbdwhqCW',
            'Authorization: key=AIzaSyCDPxW1-MFKxL6eDYkX55UPszCqd6bONBk',
            'Content-Type: application/json'//AIzaSyCDPxW1-MFKxL6eDYkX55UPszCqd6bONBk
        );

        $data = array
        (
            'to' => $deviceToken,
            'notification' => array
            (
                'title' => 'Новые объявления',
                'body' => $message
            ),
            'data' => array
            (
                'action' => 'show_message',
                'message' => $message,
                'id' => $id,
                'app_action' => 'NEW_CHAT'
            )
        );

        $options = array
        (
            'http' => array
            (
                'header'  => implode("\r\n", $headers),
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        return $response;
    }
    
    
    
    public function sendNotificationsToUsers()
    {
        $stmt = $this->con->prepare("SELECT DISTINCT Users.token
                                     FROM Users
                                     JOIN User_requests ON Users.id = User_requests.user_id
                                     JOIN New_posts ON User_requests.id = New_posts.request_id");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc())
        {
            $this->sendNotification($row);
        }
        
        $this->closeStmt($stmt);
    }
    
    
    public function getPostIdsByRequestId($request_id)
    {
        $post_ids = [];

        $stmt = $this->con->prepare("SELECT post_id FROM Post_found WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) 
        {
            $post_ids[] = $row;
        }
        
        $this->closeStmt($stmt);
        return $post_ids;
    }
    
    public function getPostsByRequestId($json, $request_id)
    {
        $post_ids = $this->getPostIdsByRequestId($request_id);
        $post_ids_new = [];
    
        foreach($json as $item)
        {
            $decoded_json = json_decode($item, true);
            $items = $decoded_json['items'];
            
            foreach($items as $link)
            {
                $id = intval(substr($link['id'], 1));
            
                if(isset($id) && $id !== 'o' && !empty($id)) //&& !in_array($id, $post_ids))
                {
                    if($key = array_search($id, $post_ids) === false)
                    {
                        $title = $link['title'];
                        $img_url = $link['image_url'];
                        $price = $link['price'];
                
                        $market = 1;
                        $stmt = $this->con->prepare("INSERT INTO Post_found(request_id, post_id, title, price, image_url, user_id, market) VALUES (?,?,?,?,?,?,?)");
                        $stmt->bind_param("iisisii", $request_id, $id, $title, $price, $img_url, $user_id, $market);
        
                        if($stmt->execute())
                        {
                            $post_ids_new[] = $id;
                        }
                    }
                }
            }
        }
        
        //var_dump($post_ids);
        //var_dump($post_ids_new);
        
        $combined_array = array_merge($post_ids, $post_ids_new);
        $posts = $this->getPostsByIds($combined_array);
        $this->closeStmt($stmt);
        
        return $posts;
    }
    
    public function parceMnogotovarovJson($json, $user_id, $request_id)
    {
        $post_ids = [];
        
        foreach($json as $item)
        {
            $decoded_json = json_decode($item, true);
            $items = $decoded_json['items'];
            
            foreach($items as $link) 
            {
                $id = substr($link['id'], 1);
    
                if(isset($id) && $id !== 'o' && !empty($id))
                {
                    $title = $link['title'];
                    $img_url = $link['image_url'];
                    $price = $link['price'];
                    
                    $market = 1;
                    $stmt = $this->con->prepare("INSERT INTO Post_found(request_id, post_id, title, price, image_url, user_id, market) VALUES (?,?,?,?,?,?,?)");
                    $stmt->bind_param("iisisii", $request_id, $id, $title, $price, $img_url, $user_id, $market);
            
                    if($stmt->execute())
                    {
                        $post_ids[] = $id;
                    }
                }
            }
        }
        
        $this->closeStmt($stmt);
        return $post_ids;
    }
    
    public function getPostsByIds($ids)
    {
        $posts = [];
        $ids_str = implode(",", $ids);
        $sql = "SELECT * FROM Post_found WHERE post_id IN ($ids_str)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) 
        {
            $posts[] = $row;
        }
        
        $this->closeStmt($stmt);
        return ['posts' => $posts];
    }
    
    public function getUserRequests($user_id)
    {
        $requests = [];
        
        $stmt = $this->con->prepare("SELECT * FROM User_requests WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc())
        {
            $requests[] = $row;
        }
        
        $this->closeStmt($stmt);
        return $requests;
    }
    
    public function addUserRequest($user_id, $text, $update_date)
    {
        $upd = 0;
        
        $stmt = $this->con->prepare("INSERT INTO User_requests(user_id, text, update_date, always_update) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $user_id, $text, $update_date, $upd);
        
        if($stmt->execute())
        {
            $id = $stmt->insert_id;
            return $id;
        }
        else
        {
            $this->closeStmt($stmt);
            return false;
        }
    }
    
    public function addUserIgnoreItems($user_id, $item_id)
    {
        $stmt = $this->con->prepare("INSERT INTO Ignore_items(item_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $item_id, $user_id);
        
        if($stmt->execute())
        {
            $this->closeStmt($stmt);
            return true;
        }
        else
        {
            $this->closeStmt($stmt);
            return false;
        }
    }
    
    public function addRequestAlwaysUpdate($request_id)
    {
        $stmt = $this->con->prepare("SELECT always_update FROM User_requests WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        $newState = 1;
        if($result['always_update'] == 1)
            $newState = 0;
        
        $stmt = $this->con->prepare("UPDATE User_requests SET always_update = ? WHERE id = ?");
        $stmt->bind_param("ii", $newState, $request_id);
        $stmt->execute();
        
        $this->closeStmt($stmt);
        return $newState;
    }
    
    //________________________________________________________________________________________________________________________________________
    
    public function updateRequests()
    {
        $updated_items = [];
        $requests = $this->getRequestsToUpdate();

        if($requests !== false)
        {
            foreach($requests as $request)
            {
                $request_id = $request['id'];
                $text = $request['text'];
                $user_id = $request['user_id'];

                $output = $this->executeParcer($request_id, $text, $user_id);

                $new_post_ids = $this->parceMnogotovarovJsonInsertCover($output, $user_id, $request_id);

                if($new_post_ids !== false)
                {
                    $this->updateRequestTime($request_id);
                
                    foreach($new_post_ids as $id)
                    {
                        $updated_items[] = $id;
                    }
                }
            }
            
            return $updated_items;
        }
        else
        {
            return false;
        }
    }
    
    public function getRequestsToUpdate()
    {
        $ids = [];
        
        $stmt = $this->con->prepare("SELECT id, text, user_id 
                                     FROM User_requests 
                                     WHERE update_date < DATE_SUB(NOW(), INTERVAL 1 HOUR) 
                                     AND always_update = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc())
        {
            $ids[] = $row;
        }
        
        if(!empty($ids))
        {
            $this->closeStmt($stmt);
            return $ids;
        }
        else
        {
            $this->closeStmt($stmt);
            return false;
        }
    }
    
    public function updateRequestTime($request_id)
    {
        $stmt = $this->con->prepare("UPDATE User_requests SET update_date = ? WHERE id = ?");
        $stmt->bind_param("di", date('YmdHis'), $request_id);
        $stmt->execute();
        $this->closeStmt($stmt);
    }
    
    public function executeParcer($request_id, $text, $user_id)
    {
        $command = '/var/www/u1059950/data/djangoenv/bin/python /var/www/u1059950/data/www/hub-24.online/Diplom/parser.py ' . $text;

        $output = array();
        exec($command, $output);
        
        if(!empty($output))
        {
            //$answer = $this->parceMnogotovarovJson($output, $user_id, $request_id);
            return $output;
        }
    }
    
    public function getPreviousPostIds($request_id)
    {
        $ids = [];
        
        $stmt = $this->con->prepare("SELECT post_id FROM Post_found WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        while($row = $result->fetch_assoc())
        {
            $ids[] = $row;
        }
        
        $this->closeStmt($stmt);
        return $ids;
    }
    
    public function parceMnogotovarovJsonInsertCover($json, $user_id, $request_id)
    {
        $post_ids = [];

        foreach ($json as $item) 
        {
            $decoded_json = json_decode($item, true);
            $items = $decoded_json['items'];

            foreach ($items as $link) 
            {
                $id = substr($link['id'], 1);

                if (isset($id) && $id !== 'o' && !empty($id)) 
                {
                    $post_ids[] = $id;
                }
            }
        }

        $previous_post_ids = $this->getPreviousPostIds($request_id);

        $new_post_ids = array_diff($post_ids, array_column($previous_post_ids, 'post_id'));

        if (!empty($new_post_ids)) 
        {
            foreach ($json as $item) 
            {
                $decoded_json = json_decode($item, true);
                $items = $decoded_json['items'];

                foreach ($items as $link) 
                {
                    $id = substr($link['id'], 1);

                    if (in_array($id, $new_post_ids)) 
                    {
                        $title = $link['title'];
                        $img_url = $link['image_url'];

                        $market = 1;
                        $stmt = $this->con->prepare("INSERT INTO Post_found(request_id, post_id, title, image_url, user_id, market) VALUES (?,?,?,?,?,?)");
                        $stmt->bind_param("iissii", $request_id, $id, $title, $img_url, $user_id, $market);
                        $stmt->execute();
                        
                        $this->addNewPost($request_id, $id, $user_id);
                        $this->closeStmt($stmt);
                    }
                }
            }
            
            $this->closeStmt($stmt);
        }
        else
        {
            return false;
        }
        
        return $new_post_ids;
    }
    
    public function addNewPost($request_id, $post_id, $user_id)
    {
        $stmt = $this->con->prepare("INSERT INTO New_posts(request_id, post_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $request_id, $post_id, );
        $stmt->execute();
        $this->closeStmt($stmt);
    }
    
    public function getNewPosts($user_id)
    {
        $posts = [];
        
        $stmt = $this->con->prepare("SELECT np.id, np.post_id, np.request_id 
                                     FROM New_posts np 
                                     JOIN User_requests ur ON np.request_id = ur.id 
                                     JOIN Users ON ur.user_id = Users.id
                                     WHERE Users.id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc())
        {
            $posts[] = $row;
        }
        
        $this->closeStmt($stmt);
        
        if(!empty($posts))
        {
            return $posts;
        }
        else
        {
            return false;
        }
    }
    
    public function deleteFromNewPosts($request_id)
    {
        $stmt = $this->con->prepare("DELETE FROM New_posts WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        
        if($stmt->execute())
        {
            $this->closeStmt($stmt);
            return true;
        }
        else
        {
            $this->closeStmt($stmt);
            return false;
        }
    }
}
?>
