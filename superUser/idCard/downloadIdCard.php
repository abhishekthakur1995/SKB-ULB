<?php
 ini_set('max_execution_time', 10000); 
    session_start();

    require('../../config.php');
    require('../../languages/hi/lang.hi.php');
    require('../../common/common.php');
    require('../../vendor/autoload.php');
    
    function generatePDF() {
        $mpdf = new mPDF('utf-8', 'A4-C');
        $mpdf->SetImportUse();
        $mpdf->text_input_as_HTML = TRUE;
        define('_MPDF_TTFONTDATAPATH', sys_get_temp_dir()."/");

        $stylesheet = file_get_contents('../../css/letter.css');
        $data = Common::getCandidatesForIdCard();

        for($i=0; $i<100; $i++) {
            $pagecount = $mpdf->SetSourceFile('image/img.pdf');
            $tplId = $mpdf->ImportPage($pagecount);
            $mpdf->UseTemplate($tplId);
            
            $mpdf->WriteHTML($stylesheet, 1);

            $address = Common::getFormattedAddress($data[$i]['permanentAddress']);
            $line1 = $address[0]." ".$address[1]." ".$address[2]." ".$address[3]." ".$address[4]."".$address[5];
            $line2 = $address[6]." ".$address[7]." ".$address[8]." ".$address[9]." ".$address[10];

            $mpdf->WriteFixedPosHTML($data[$i]['name'], 70, 162, 100, 100, 'hidden');
            $mpdf->WriteFixedPosHTML($data[$i]['guardian'], 70, 262, 100, 100, 'hidden');
            $mpdf->WriteFixedPosHTML($line1, 70, 262, 100, 100, 'hidden');
            $mpdf->WriteFixedPosHTML($line2, 70, 362, 100, 100, 'hidden');
            $mpdf->WriteFixedPosHTML($data[$i]['ulbRegion'], 70, 462, 100, 100, 'hidden');

            if($i != sizeof($data)-1) {
                $mpdf->AddPage();
            }
        }
        $mpdf->Output('id.pdf', 'D');
    }

    function generateImg() {
        $data = Common::getCandidatesForIdCard();
        mkdir($data[0]['ulbRegion'], 0777, true);
        for($i=1000; $i<1947; $i++) {
            $image = new Imagick("image/img.jpeg");
            $draw = new ImagickDraw();

            /* Font properties */
            $draw->setFont('fonts/MANGAL.TTF');
            $draw->setFontSize(30);
            $draw->setTextEncoding('UTF-8');

            /* Create text */
            $address = Common::getFormattedAddress($data[$i]['permanentAddress']);
            $line1 = $address[0]." ".$address[1]." ".$address[2]." ".$address[3]." ".$address[4];
            $line2 = $address[5]." ".$address[6]." ".$address[7]." ".$address[8]." ".$address[9];
            $image->annotateImage($draw, 320, 740, 0, $data[$i]['name']);
            $image->annotateImage($draw, 320, 840, 0, $data[$i]['guardian']);
            $image->annotateImage($draw, 320, 940, 0, $line1);
            $image->annotateImage($draw, 60, 1040, 0, $line2);
            $image->annotateImage($draw, 320, 1140, 0, $data[$i]['ulbRegion']);

            /* Give image a format */
            $image->setImageFormat('png');
            $image->minifyImage();
            
            header('Content-type: image/png');
            file_put_contents($data[0]['ulbRegion']."/imagick_ouput_".$i.".png" , $image);
        }
    }

    generatePDF();

?>