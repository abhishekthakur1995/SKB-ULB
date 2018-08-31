<?php
    session_start();

    require('config.php');
    require('languages/hi/lang.hi.php');
    require('common/common.php');

    for($i = 0; $i < 2; $i++) {
        $image = new Imagick("image/img.jpeg");
        $draw = new ImagickDraw();

        /* Font properties */
        $draw->setFont('fonts/MANGAL.TTF');
        $draw->setFontSize(30);
        $draw->setTextEncoding('UTF-8');

        /* Create text */
        $image->annotateImage($draw, 320, 740, 0, 'Jeetan Ram');
        $image->annotateImage($draw, 320, 840, 0, 'Ram Naresh');
        $image->annotateImage($draw, 320, 940, 0, 'SD 198 Shanti Nagar Hatwara Road');
        $image->annotateImage($draw, 320, 1040, 0, 'Near ESI Hospital Jaipur');
        $image->annotateImage($draw, 320, 1140, 0, 'Jaipur');

        /* Give image a format */
        $image->setImageFormat('png');
        
        header('Content-type: image/png');
        file_put_contents("imagick_ouput_".$i.".png" , $image);
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
?>

