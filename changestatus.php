

<?php
include("path.php");
include(ROOT_PATH . "/app/database/db.php");
getEvent($_SESSION['id']);
header('location: ' . BASE_URL . '/userSection.php');  ?>