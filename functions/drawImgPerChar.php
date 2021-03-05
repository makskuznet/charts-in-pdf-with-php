<?php

define('GRAPH_WIDTH', 800);
define('GRAPH_HEIGHT', 450);
$im1gHeight = GRAPH_HEIGHT + 10;
$im1 = imagecreatetruecolor(GRAPH_WIDTH + 50, $im1gHeight);
$font = __DIR__ . "/../font/unifont/arial.ttf";

//цвета
$white = ImageColorAllocate ($im1, 255, 255, 255);
$black = ImageColorAllocate ($im1, 0, 0, 0);
$red = ImageColorAllocate ($im1, 255,65,65);
$green = ImageColorAllocate ($im1, 11,132,9);
$blue = ImageColorAllocate ($im1, 22,13,215);
$yellow = ImageColorAllocate ($im1, 235,122,9);
$grey = ImageColorAllocate ($im1, 125,125,125);
$lightGrey = ImageColorAllocate ($im1, 231,231,231);
$blueGrey = ImageColorAllocate ($im1, 79,113,161);
$lightRed = ImageColorAllocate ($im1, 231,97,101);
$lightGreen = ImageColorAllocate ($im1, 155,187,89);

//$filename2 = pow(mt_rand(1,mt_getrandmax()),2) * mt_rand(1, 999);
$filename2 = uniqid();
$file2 = __DIR__ . "/../tmp_img/chart2_" . $filename2 . ".png";

imagefill($im1, 0, 0, $white);


$x0=75; //начало оси координат по X
$y0=75;//начало оси координат по Y
$maxX=GRAPH_WIDTH - $x0; //максимальное значение оси
//координат по X в пикселах
$maxY=GRAPH_HEIGHT-$y0; //максимальное значение оси
//функция для осей

function drawAxisesPer(){
    global $im1,$grey, $lightGrey,$x0,$y0,$maxX,$maxY;

    imageline($im1, $x0, $maxY, $maxX, $maxY, $lightGrey);


    //рисуем ось Y

    imageline($im1, $x0, $y0, $x0, $maxY, $grey);
    imageline($im1, 725, $y0, 725, $maxY, $grey);
    imageline($im1, $x0, $y0, $maxX, $y0, $grey);
}

function drawGridPer($xStep=43.3, $yStep = 33.25){
    global $im1,$lightGrey,$x0,$y0,$maxX,$maxY;
    $xSteps=($maxX-$x0)/$xStep-1; //определяем количество
//шагов по оси X
    $ySteps=($maxY-$y0)/$yStep-1; //определяем количество
//шагов по оси Y
//выводим сетку по оси X
    for($i=1;$i<$xSteps+1;$i++){
        imageline($im1, $x0+$xStep*$i, $y0, $x0+$xStep*$i,$maxY-1, $lightGrey);

    }
//выводим сетку по оси Y
    for($i=1;$i<$ySteps+1;$i++){
        imageline($im1, $x0+1, $maxY-$yStep*$i, $maxX,
            $maxY-$yStep*$i, $lightGrey);

    }
}
function drawNumsPer($mstep = 4, $ftstep = 10, $flowbpdstep = 200, $flowmdsstep = 20, $kwstep = 0.2, $effstep = 10){
    global $im1,$blue, $grey, $font,$x0, $maxY;
    $m = 0;
    $ft = 0;
    $flowbpd = 0;
    $flowmd = 0;
    $kw = 0;
    $eff = 0;
    $k = $maxY;
    for ($i=1; $i <=7; $i++){
        if($ft==0){
            imagettftext($im1, 10, 0, 60 , $k-5, $blue, $font, $ft);
        }else{
            imagettftext($im1, 10, 0, 55 , $k-5, $blue, $font, $ft);
        }
        $k -=48;
        $ft += $ftstep;
    }
    $k = $x0;
    for ($i=1; $i <=6; $i++){
        imagettftext($im1, 10, 0, $k-5 , 395, $grey, $font, $flowbpd);
        $k +=120;
        $flowbpd += $flowbpdstep;
    }
    $k = $x0;
    for ($i=1; $i <=8; $i++){
        imagettftext($im1, 10, 0, $k-5 , 65, $grey, $font, $flowmd);
        $k +=82.5;
        $flowmd += $flowmdsstep;
    }
    $k = $maxY;
    for($i=1; $i <=5; $i++){
        imagettftext($im1, 10, 0, 730 , $k+5, $blue, $font, $m);
        $k-=75;
        $m+=$mstep;
    }

}

function valuePer(){
    global $im1, $blue,$grey,$font;
    imagettftext($im1, 10, 0, 350, 425, $grey, $font, 'F');
    imagettftext($im1, 10, 0, 355, 425, $grey, $font, ' lowrate, bpd');
    imagettftext($im1, 10, 0, 350, 25, $grey, $font, 'F');
    imagettftext($im1, 10, 0, 355, 25, $grey, $font, ' lowrate, m /d');
    imagettftext($im1, 6, 0, 419, 20, $grey, $font, '3');
    imagettftext($im1, 10, 0, 730, 50, $blue, $font, 'm');
    imagettftext($im1, 10, 0, 55, 50, $blue, $font, 'ft');
}


function bildGraphPer($array, $сdred, $arr){
    $file = "images/img2.png";
    global $im1,$grey,$lightGreen,$blueGrey, $white,$black,$blue,$lightRed,$red,$x0,$y0,$maxX,$maxY, $font;
    $curves = array();
    $curves[] = new AkimaSpline();
    $colors[] = $blue;
    $i = 0;
//гр 1
    foreach($curves as $k => $curve){
        foreach ($array as $item){
            $curve->setCoords($item);

            $r = $curve->process();
            $curveGraph = new Plot($r);

            $curveGraph->drawAALine($im1, $colors[$k], 75, 375);
            $i++;
        }
    }

    $curvesre = array();
    $curvesre[] = new AkimaSpline();
    $colorsre[] = $red;
    $i = 0;
//красная линия
    foreach($curvesre as $k => $curvere){
        $curvere->setCoords($сdred);

        $r = $curvere->process();
        $curveGraphre = new Plot($r);

        $curveGraphre->drawAALine($im1, $colorsre[$k], 75, 375);
    }

    $ax = [
        150=>225,
        140=>190,
        50 => 59
    ];


    $ax1 = [
        275=>135,
        250=>100,
        150 => 20
    ];

    $arrax = array($ax, $ax1);


//сдесь мы рисуем графики
    $curves1 = array();
    $curves1[] = new AkimaSpline();
    $colors1[] = $grey;
//гр 1
    foreach($curves1 as $q => $curve1){
        foreach ($arrax  as $item){
            $curve1->setCoords($item);

            $z = $curve1->process();
            $curveGraph1 = new Plot($z);

            $curveGraph1->drawAALine($im1, $colors1[$q], 75, 375);
        }
    }


    $num = 30;
    for($i=0;$i<=5;$i++){
        imagefilledrectangle($im1, 20, $arr[$i]+7 , 50, $arr[$i] -7, $blueGrey);
        imagettftext($im1, 7.5, 0, 20, $arr[$i]+5, $white, $font,$num . ' ' . 'Гц');
        $num += 10;
    }



    $str = array("QMin", "Вер", "QMax");
    imagefilledrectangle($im1, 220, 142, 240, 130, $lightGreen);
    imagettftext($im1, 7.5, 0, 220, 140, $black, $font,"QMin");
    imagefilledrectangle($im1, 290, 165, 310, 177, $grey);
    imagettftext($im1, 7.5, 0, 290, 175 , $black, $font,"Вер");
    imagefilledrectangle($im1, 350, 237, 372, 225, $lightGreen);
    imagettftext($im1, 7.5, 0, 350, 235, $black, $font,"QMax");



    $axr = [
        220=>190,
        150=>90,
        100 => 45
    ];
//сдесь мы рисуем графики
    $curves2 = array();
    $curves2[] = new AkimaSpline();
//гр 1
    foreach($curves2 as $c => $curve2){
        $curve2->setCoords($axr);

        $x = $curve2->process();
        $curveGraph2 = new Plot($x);

        $curveGraph2->drawAALine($im1, $lightRed, 75, 375);
    }



}

function ballPer($ballX,$ballY, $color){
    global $im1, $x0, $y0, $maxX, $maxY, $grey;

    imagedashedline (  $im1, $x0 , $ballY , $ballX-5, $ballY , $grey);
    imagedashedline (  $im1, $ballX, $ballY+5 , $ballX, $maxY , $grey);

    imagefilledellipse($im1, $ballX, $ballY, 10, 10, $color);
}

function drawPer(){
    global $im1, $file2;
    imagepng($im1,  $file2, null, PNG_ALL_FILTERS);
    imagedestroy($im1);

}