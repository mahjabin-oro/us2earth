<?php

session_start();
require('connect.php');



function dd($value) // to be deleted
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}


function executeQuery($sql, $data) //just take associative  arrays
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}


function selectAll($table, $conditions = [])
{
    global $conn;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
        
        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}

function SendInvitation($bodyy,$time,$user)
{
    $sql= "SELECT email FROM users where id=?"; 
   $stmt = executeQuery($sql,['user_id'=>$user]);
   $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   $record=$records[0]['email'];
    $detail=html_entity_decode($bodyy);
    $details= $detail . "For more information, contact : ". $record; 
 
   
$conditions=[
    'getmail'=> 1];
$a=selectAll('users',$conditions);

    foreach ($a as $key => $user): 
            $selected =  $user['email']  ;
            $to_email = $selected ;

$subject = "New Event at $time";
$body = "Hi, $details";
$headers = "From: mahjabin1807047@stud.kuet.ac.bd";

if (mail($to_email, $subject, $body, $headers)) {

} else {
echo "Email sending failed...";
}
    endforeach;


}


function selectOne($table, $conditions)
{
    global $conn;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
}


function create($table, $data)
{
    global $conn;
    $sql = "INSERT INTO $table SET ";
    //$sql="Insert into users set username=?,admin=?,email=?,password=?"
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}



function update($table, $id, $data)
{
    global $conn;
    $sql = "UPDATE $table SET ";
     //update users set username=? where id=?
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}



function delete($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";

    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}


function getPublishedPosts()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";

    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}
function getNPublishedPosts()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";

    $stmt = executeQuery($sql, ['published' => 0]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getAlllPosts()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id";

    $stmt = executeQuery($sql,['published' => '1']);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


function getPostsByTopicId($topic_id)
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=?";

    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}



function searchPosts($term)
{
    $match = '%' . $term . '%';
    global $conn;
    $sql = "SELECT 
                p.*, u.username 
            FROM posts AS p 
            JOIN users AS u 
            ON p.user_id=u.id 
            WHERE p.published=?
            AND p.title LIKE ? OR p.body LIKE ?";


    $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getUsersPosts($user)
{
   global $conn;
   $sql= "SELECT * FROM posts where user_id=?"; 
   $stmt = executeQuery($sql,['user_id'=>$user]);
   $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   return $records;

}

function getPublishedEvents()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM events AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";

    $stmt = executeQuery($sql, ['published' => 1]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


function getNPublishedEvents()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM events AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";

    $stmt = executeQuery($sql, ['published' => 0]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getAlllEvents()
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM events AS p JOIN users AS u ON p.user_id=u.id";

    $stmt = executeQuery($sql,['published' => '1']);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


function getEventsByTopicId($topic_id)
{
    global $conn;
    $sql = "SELECT p.*, u.username FROM events AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=?";

    $stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}



function searchEvents($term)
{
    $match = '%' . $term . '%';
    global $conn;
    $sql = "SELECT 
                p.*, u.username 
            FROM events AS p 
            JOIN users AS u 
            ON p.user_id=u.id 
            WHERE p.published=?
            AND p.title LIKE ? OR p.body LIKE ?";


    $stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]);
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}

function getUsersEvents($user)
{

   global $conn;
   $sql= "SELECT * FROM events where user_id=? AND published=1"; 
   $stmt = executeQuery($sql,['user_id'=>$user]);

   $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   
   return $records;

}



function mailedcondition($user)
{
    global $conn;
   $sql= "SELECT getmail FROM users where id=? and getmail='1'"; 
   $stmt = executeQuery($sql,['id'=>$user]);
   $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   return $records;
}

function getEvent($user)
{
    global $conn;
    $sql= "UPDATE users SET getmail='1' where id=?"; 
    $stmt = executeQuery($sql,['id'=>$user]);
    $records = $stmt->get_result();
    return $records;
}

function getEventZero($user)
{
    global $conn;
    $sql= "UPDATE users SET getmail='0' where id=?"; 
    $stmt = executeQuery($sql,['id'=>$user]);
    $records = $stmt->get_result();
    return $records;
}


