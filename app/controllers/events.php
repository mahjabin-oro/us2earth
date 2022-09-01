<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateEvents.php");

$table = 'events';

$topics = selectAll('topics');
$posts = selectAll($table);


$errors = array();
$id = "";
$title = "";
$body = "";
$topic_id = "";
$created_at="";
$published = "";



if (isset($_GET['id'])) {
    $post = selectOne($table, ['id' => $_GET['id']]);

    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $topic_id = $post['topic_id'];
    $created_at=$post['event_time'];
    $published = $post['published'];
  
}

if (isset($_GET['delete_id'])) {
    
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Event deleted successfully";
    $_SESSION['type'] = "success";
    if ($_SESSION['admin']) {
        header('location: ' . BASE_URL . '/admin/events/index.php'); 
    } else {
        header('location: ' . BASE_URL . '/userSection.php');
    }
    exit();
}

if (isset($_GET['published']) && isset($_GET['p_id'])) {
    
    $published = $_GET['published'];
    
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['published' => $published]);
    $_SESSION['message'] = "Post published state changed!";
    $_SESSION['type'] = "success";
    if($_POST['published']=='0')
    {
        SendInvitation($_POST['body'],$_POST['event_time'],$_SESSION['id']);
    }
    if ($_SESSION['admin']) {
        header('location: ' . BASE_URL . '/admin/events/index.php'); 
    } else {
        header('location: ' . BASE_URL . '/userSection.php');
    }
    exit();
}



if (isset($_POST['add-event'])) {
    
    $errors = validateEvents($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
           $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    } else {
       array_push($errors, "Post image required");
    }
    if (count($errors) == 0) {
        unset($_POST['add-event']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['event_time']=($_POST['event_time']);
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Event created successfully";
        $_SESSION['type'] = "success";
        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/admin/events/index.php'); 
        } else {
            header('location: ' . BASE_URL . '/userSection.php');
        }
        exit();    
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $created_at=$_POST['event_time'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}


if (isset($_POST['update-event'])) {
    
    $errors = validateEvents($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
           $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    } 

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-event'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['event_time']=$_POST['event_time'];
        $post_id = update($table, $id, $_POST);
        if($_POST['published']==1)
        {
            SendInvitation($_POST['body'],$_POST['event_time'],$_SESSION['id']);
        }
        
        $_SESSION['message'] = "event updated successfully";
        $_SESSION['type'] = "success";
        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/admin/posts/index.php'); 
        } else {
            header('location: ' . BASE_URL . '/userSection.php');
        }   
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $created_at=$_POST['event_time'];
        $published = isset($_POST['published']) ? 1 : 0;
    }

}