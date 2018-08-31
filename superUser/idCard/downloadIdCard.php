<?php
 ini_set('max_execution_time', 10000); 
    session_start();

    require('../../config.php');
    require('../../languages/hi/lang.hi.php');
    require('../../common/common.php');

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


    // $path = Yii::app()->basePath."/imagick.jpeg";
    // $img = new Imagick($path);
    // $img->resizeImage(80,80, imagick::FILTER_LANCZOS, 0.9, true);
    // $img->cropImage (80,80,0,0);
    // $img->writeImage(Yii::app()->basePath."/imagick1.jpeg");
    // pr($img->getImageGeometry());

    //To get attachment
    // header('Content-Disposition: attachment; filename=data.png');

    //$draw->setFont('Bookman-DemiItalic');
?>