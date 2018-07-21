<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'abhishek_candidate_selection_portal');
define('ULB_ADMIN_TABLE', 'ulb_admins');
define('PASSWORD_REQUIRED_LENGTH', 6);
define('IDLE_TIME', 900000);
define('DEFAULT_PASSWORD', 'password_9807');
define('BASE_URL', "/candidate_portal");
define("TBL_ATTEMPTS", "login_attempts");
define("ATTEMPTS_NUMBER", "20");
define("TIME_PERIOD", "10");

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($link, "utf8mb4");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>