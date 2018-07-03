<?php
session_start();
require('config.php');
require('languages/hi/lang.hi.php');
require('common/common.php');
require('vendor/autoload.php');
require('Mustache/Autoloader.php');
Mustache_Autoloader::register();
$mustache = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates') 
));
$mpdf = new mPDF();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: index.php");
    exit;
} else {
    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
        header("location: logout.php");
    } else {
        $_SESSION['timestamp']=time();
    }
}

header('Content-Type: application/pdf');
for($i=0; $i<5; $i++) {
	$template = $mustache->loadTemplate('letter');
	$html = $template->render();
	$mpdf->WriteHTML("नाम");
	$mpdf->AddPage();
}
header('Content-Type: application/pdf');
$mpdf->Output();
?>
