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

$data = Common::getSelectedCandidates();
for($i=0; $i<sizeof($data); $i++) {
	$template = $mustache->loadTemplate('letter');
	$html = $template->render(array(
            'name'=>$data[$i]['name'],
            'guardian'=>$data[$i]['guardian'],
            'permanentAddress'=>$data[$i]['permanentAddress'],
            'dob'=>$data[$i]['dob'],
            'receiptNumber'=>$data[$i]['receiptNumber'],
            'getReceiptNumber' => function($text, Mustache_LambdaHelper $helper) {
                return substr($helper->render($text), strpos($helper->render($text), "_") + 1);
            },
        )
    );
    $mpdf->WriteHTML($stylesheet, 1);
	$mpdf->WriteHTML($html);
    if($i != sizeof($data)-1) {
        $mpdf->AddPage();
    }
}

$mpdf->Output('appoinment_letter.pdf', 'D');
?>
