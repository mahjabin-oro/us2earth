<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/events.php");
$Nevents= getNPublishedEvents();
$events = getPublishedEvents();
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
        <link rel="stylesheet" href="../../assets/css/style.css?<?php echo time()?>">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css?<?php echo time()?>">

        <title>Admin Section - Manage Events</title>
    </head>

    <body class="exception">
        
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Add Events</a>
                    <a href="index.php" style="float:right;" class="btn btn-big">Manage Events</a>
                </div>


                <div class="content">

                    <h2 class="page-title">Unpublished Events</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Creator</th>
                            <th colspan="3">Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($Nevents as $key => $nevent): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $nevent['title'] ?></td>
                                    <td><?php echo $nevent['username'] ?></td>
                                    <td><?php echo $nevent['event_time'] ?></td>
                                    <td><a href="edit.php?id=<?php echo $nevent['id']; ?>" class="edit">edit</a></td>
                                    <td><a href="edit.php?delete_id=<?php echo $nevent['id']; ?>" class="delete">delete</a></td>

                                    <?php if ($nevent['published']): ?>
                                        <td><a href="edit.php?published=0&p_id=<?php echo $nevent['id'] ?>" class="unpublish">unpublish</a></td>
                                    <?php else: ?>
                                        <td><a href="edit.php?published=1&p_id=<?php echo $nevent['id'] ?>" class="publish">publish</a></td>
                                    <?php endif; ?>
                                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
                <div class="content">

                    <h2 class="page-title">Published Events</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Creator</th>
                            <th>Event_Time</th>
                            <th colspan="3">Action</th>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $key => $event): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $event['title'] ?></td>
                                    <td><?php echo $event['username'] ?></td>
                                    <td><?php echo $event['event_time'] ?></td>
                                    <td><a href="edit.php?id=<?php echo $event['id']; ?>" class="edit">edit</a></td>
                                    <td><a href="edit.php?delete_id=<?php echo $event['id']; ?>" class="delete">delete</a></td>

                                    <?php if ($event['published']): ?>
                                        <td><a href="edit.php?published=0&p_id=<?php echo $event['id'] ?>" class="unpublish">unpublish</a></td>
                                    <?php else: ?>
                                        <td><a href="edit.php?published=1&p_id=<?php echo $event['id'] ?>" class="publish">publish</a></td>
                                    <?php endif; ?>
                                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

            </div>
            <!-- // Admin Content -->

        </div>
        <!-- // Page Wrapper -->



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