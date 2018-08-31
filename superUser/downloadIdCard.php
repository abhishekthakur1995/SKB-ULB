<?php
    // $path = Yii::app()->basePath."/imagick.jpeg";
    // $img = new Imagick($path);
    // $img->resizeImage(80,80, imagick::FILTER_LANCZOS, 0.9, true);
    // $img->cropImage (80,80,0,0);
    // $img->writeImage(Yii::app()->basePath."/imagick1.jpeg");
    // pr($img->getImageGeometry());

    $image = new Imagick("img.jpeg");
    $draw = new ImagickDraw();

    /* Font properties */
    $draw->setFont('Bookman-DemiItalic');
    $draw->setFontSize( 30 );

    /* Create text */
    $image->annotateImage($draw, 320, 740, 0, 'Jeetan Ram');
    $image->annotateImage($draw, 320, 840, 0, 'Ram Naresh');
    $image->annotateImage($draw, 320, 940, 0, 'SD 198 Shanti Nagar Hatwara Road');
    $image->annotateImage($draw, 320, 1040, 0, 'Near ESI Hospital Jaipur');
    $image->annotateImage($draw, 320, 1140, 0, 'Jaipur');

    /* Give image a format */
    $image->setImageFormat('png');
    header('Content-type: image/png');
    header('Content-Disposition: attachment; filename=data.png');
    file_put_contents(basename(__DIR__) , $image);
    echo $image;
?>