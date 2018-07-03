<?php
session_start();
require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');
require('vendor/autoload.php');
$mpdf = new mPDF();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
} else {
    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
        header("location: logout.php");
    }   else{
        $_SESSION['timestamp']=time();
    }
}

$mpdf->WriteHTML('Hello World');
$mpdf->Output();

?>
