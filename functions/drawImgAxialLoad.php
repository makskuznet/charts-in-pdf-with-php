<?php
define('GRAPH_WIDTH1', 800);
define('GRAPH_HEIGHT1', 125);

$im4gHeight = GRAPH_HEIGHT1 + 10;
$im4 = imagecreatetruecolor(GRAPH_WIDTH1 + 50, $im4gHeight);
$font = __DIR__ . "/../font/unifont/arial.ttf";
//цвета
$white = ImageColorAllocate($im3, 255, 255, 255);
$black = ImageColorAllocate($im3, 0, 0, 0);
$red = ImageColorAllocate($im3, 255, 65, 65);
$green = ImageColorAllocate($im3, 11, 132, 9);
$blue = ImageColorAllocate($im3, 22, 13, 215);
$yellow = ImageColorAllocate($im3, 235, 122, 9);
$grey = ImageColorAllocate($im3, 125, 125, 125);
$lightGrey = ImageColorAllocate($im3, 231, 231, 231);

//$filename4 = pow(mt_rand(1,mt_getrandmax()),2) * mt_rand(1, 999);
$filename4 = uniqid();
$file4 = __DIR__ . "/../tmp_img/chart4_" . $filename4 . ".png";

imagefill($im4, 0, 0, $white);

$x01 = 75; //начало оси координат по X
$y01  = 10;//начало оси координат по Y
$maxX1 = GRAPH_WIDTH1 - $x01; //максимальное значение оси
//координат по X в пикселах
$maxY1 = 78; //максимальное значение оси
//функция для осей
function drawAxisesAxialLoad()
{
    global $im4, $grey, $lightGrey, $x01, $y01 , $maxX1, $maxY1;

    imageline($im4, $x01, $maxY1, $maxX1, $maxY1, $lightGrey);

    //рисуем ось Y

    imageline($im4, $x01, $y01 , $x01, $maxY1, $grey);
    imageline($im4, 725, $y01 , 725, $maxY1, $grey);
    //рисуем другя линии


}

function drawGridAxialLoad($xStep = 43.3, $yStep = 33.25)
{
    global $im4, $lightGrey, $x01, $y01 , $maxX1, $maxY1;
    $xSteps = ($maxX1 - $x01) / $xStep - 1; //определяем количество
//шагов по оси X
    $ySteps = ($maxY1 - $y01 ) / $yStep - 1; //определяем количество
//шагов по оси Y
//выводим сетку по оси X
    for ($i = 1; $i < $xSteps + 1; $i++) {
        imageline($im4, $x01 + $xStep * $i, $y01 , $x01 + $xStep * $i, $maxY1 - 1, $lightGrey);

    }
//выводим сетку по оси Y
    for ($i = 1; $i < $ySteps + 1; $i++) {
        imageline($im4, $x01 + 1, $maxY1 - $yStep * $i, $maxX1,
            $maxY1 - $yStep * $i, $lightGrey);

    }
}


function drawNumsAxialLoad($flowbpdstep = 200)
{
    global $im4, $grey, $font, $x01, $maxY1;
    $flowbpd = 0;

    $k = $maxY1;
    imagettftext($im4, 10, 0, 55, $k - 5, $grey, $font, "0");
    imagettftext($im4, 10, 0, 55, 49, $grey, $font, "1");
    imagettftext($im4, 10, 0, 55, 25, $grey, $font, "1");
    $k = $x01;
    for ($i = 1; $i <= 6; $i++) {
        imagettftext($im4, 10, 0, $k - 5, 100, $grey, $font, $flowbpd);
        $k += 120;
        $flowbpd += $flowbpdstep;
    }


}


function valueAxialLoad()
{
    global $im4, $grey, $font;
    imagettftext($im4, 10, 0, 350, 120, $grey, $font, 'F');
    imagettftext($im4, 10, 0, 355, 120, $grey, $font, ' lowrate, m /d');
    imagettftext($im4, 6, 0, 419, 115, $grey, $font, '3');
    imagettftext($im4, 10, 0, 10, 20, $grey, $font, "Axial");
    imagettftext($im4, 10, 0, 10, 35, $grey, $font, "loads");

}


function bildGraphAxialLoad($coord, $color){
    global $blue,$red,$im4;
    $curves = array();
    $curves[] = new AkimaSpline();
    $colors[] = $blue;

//гр 1
    foreach ($curves as $k => $curve) {

        $curve->setCoords($coord);
        $r = $curve->process();
        $curveGraph = new Plot($r);

        $curveGraph->drawAALine($im4,$color, 75, 78);

    }
}
function ballAxialLoad($ballX,$ballY, $color){
    global $im4;

    imagefilledellipse($im4 , $ballX, $ballY, 10, 10, $color);
}
function drawAxialLoad(){
    global $im4, $file4;
    imagepng($im4,  $file4, null, PNG_ALL_FILTERS);
    imagedestroy($im4);

}