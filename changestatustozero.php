

<?php
include("path.php");
include(ROOT_PATH . "/app/database/db.php");
getEventZero($_SESSION['id']);
header('location: ' . BASE_URL . '/userSection.php');  ?>