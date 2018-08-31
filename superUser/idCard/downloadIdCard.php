<?php
    session_start();

    require('../../config.php');
    require('../../languages/hi/lang.hi.php');
    require('../../common/common.php');

    $data = Common::getCandidatesForIdCard();

    for($i=0; $i<sizeof($data); $i++) {
        $image = new Imagick("image/img.jpeg");
        $draw = new ImagickDraw();

        /* Font properties */
        $draw->setFont('fonts/MANGAL.TTF');
        $draw->setFontSize(30);
        $draw->setTextEncoding('UTF-8');

        /* Create text */
        $image->annotateImage($draw, 320, 740, 0, $data[$i]['name']);
        $image->annotateImage($draw, 320, 840, 0, $data[$i]['guardian']);
        $image->annotateImage($draw, 320, 940, 0, $data[$i]['ulbRegion']);
        $image->annotateImage($draw, 60, 1040, 0, $data[$i]['ulbRegion']);
        $image->annotateImage($draw, 320, 1140, 0, $data[$i]['ulbRegion']);

        /* Give image a format */
        $image->setImageFormat('png');
        
        header('Content-type: image/png');

        //mkdir('ulbName', 0777, true);
        file_put_contents("ulbName/imagick_ouput_".$i.".png" , $image);

        //file_put_contents("imagick_ouput_".$i.".png" , $image);
        echo $image;
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

    // getAddressLine($address) {
    //     $addressArr = [];
    //     $addressArr['line1'] = ;
    //     $addressArr['line2'] = ;
    //     return $addressArr;
    // }
?>

