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
$stylesheet = file_get_contents('css/letter.css');
$mpdf = new mPDF('utf-8', 'A4-C');
$mpdf->text_input_as_HTML = TRUE;


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

for($i=0; $i<5; $i++) {
	$template = $mustache->loadTemplate('letter');
	$html = $template->render();
    $mpdf->WriteHTML($stylesheet, 1);
	$mpdf->WriteHTML($html);
	$mpdf->AddPage();
}
$mpdf->Output();
?>
