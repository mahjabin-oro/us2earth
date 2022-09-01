<?php include("path.php"); 
include(ROOT_PATH . "/app/controllers/posts.php");
$posts = getUsersPosts($_SESSION['id']);
$events=getUsersEvents($_SESSION['id']);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Candal|Lora"
            rel="stylesheet">

        <!-- Custom Styling -->
        <link rel="stylesheet" href="assets/css/style.css?<?php echo time()?>">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="assets/css/admin.css?<?php echo time()?>">

        <title>User Section - Manage Posts</title>
    </head>

    <body class="exception">
        
    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

     


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href=<?php echo BASE_URL ."/admin/posts/create.php" ?> class="btn btn-big">Add Post</a>
                    <a href=<?php echo BASE_URL ."/admin/events/create.php" ?> style="float:right;"class="btn btn-big two">Add Events</a>

                </div>


                <div class="content">

                    <h2 class="page-title">Manage Posts</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th colspan="3">Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $key => $post): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $post['title'] ?></td>
                                    <td><?php echo $_SESSION['username'] ?></td>
                                    <td><a href="http://localhost/blog/admin/posts/edit.php?id=<?php echo $post['id']; ?>" class="edit">edit</a></td>
                                    
                                    <td><a href="http://localhost/blog/admin/posts/edit.php?delete_id=<?php echo $post['id']; ?>" class="delete">delete</a></td>

                                    <?php if ($post['published']): ?>
                                        <td><a href="http://localhost/blog/admin/posts/edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="unpublish">unpublish</a></td>
                                    <?php else: ?>
                                        <td><a href="http://localhost/blog/admin/posts/edit.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">publish</a></td>
                                    <?php endif; ?>
                                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <h2 class="page-title">Manage Events</h2>
                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Event Time</th>
                            <th colspan="3">Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $key => $event): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $event['title'] ?></td>
                                    <td><?php echo $_SESSION['username'] ?></td>
                                    <td><?php echo $event['event_time'] ?></td>
                                    <td><a href="http://localhost/blog/admin/events/edit.php?id=<?php echo $event['id']; ?>" class="edit">edit</a></td>
                                    
                                    <td><a href="http://localhost/blog/admin/events/edit.php?delete_id=<?php echo $event['id']; ?>" class="delete">delete</a></td>

                                    <?php if ($event['published']): ?>
                                        <td><a href="http://localhost/blog/admin/events/edit.php?published=0&p_id=<?php echo $event['id'] ?>" class="unpublish">unpublish</a></td>
                                    <?php else: ?>
                                        <td><a href="http://localhost/blog/admin/events/edit.php?published=1&p_id=<?php echo $event['id'] ?>" class="publish">publish</a></td>
                                    <?php endif; ?>
                                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <br>
                    <br>
                 <hr> 
                 <hr>
                 <br>
                 <br>
                 <div>
                
                            <?php if (mailedcondition($_SESSION['id'])): ?>
        
                               You are subscribed to get the notification of all upcoming events. <a href="changestatustozero.php" style="color:green;">Click here to change.</a>
                            <?php else: ?>
                                You are not subscribed to get the notification of all upcoming events.  <a href="changestatus.php" style="color:green;">Click here to change.</a>
                            <?php endif; ?>
                           
                
                        </div>



                </div>

            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Page Wrapper -->

        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

        <!-- JQuery -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Ckeditor -->
        <script
            src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
        <!-- Custom Script -->
        <script src="../../assets/js/scripts.js"></script>

    </body>

</html>