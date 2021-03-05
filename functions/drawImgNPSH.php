<?php
define('GRAPH_WIDTH1', 800);
define('GRAPH_HEIGHT1', 125);

$im3gHeight = GRAPH_HEIGHT1 + 10;
$im3 = imagecreatetruecolor(GRAPH_WIDTH1 + 50, $im3gHeight);
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

//$filename3 = pow(mt_rand(1,mt_getrandmax()),2) * mt_rand(1, 999);
$filename3 = uniqid();
$file3 = __DIR__ . "/../tmp_img/chart3_" . $filename3 . ".png";

imagefill($im3, 0, 0, $white);


$x01 = 75; //начало оси координат по X
$y01  = 10;//начало оси координат по Y
$maxX1 = GRAPH_WIDTH1 - $x01; //максимальное значение оси
//координат по X в пикселах
$maxY1 = 78; //максимальное значение оси
//функция для осей
function drawAxisesNpsh()
{
    global $im3, $grey, $lightGrey, $x01, $y01 , $maxX1, $maxY1;

    imageline($im3, $x01, $maxY1, $maxX1, $maxY1, $lightGrey);

    //рисуем ось Y

    imageline($im3, $x01, $y01 , $x01, $maxY1, $grey);
    imageline($im3, 725, $y01 , 725, $maxY1, $grey);
    //рисуем другя линии


}

function drawGridNpsh($xStep = 43.3, $yStep = 33.25)
{
    global $im3, $lightGrey, $x01, $y01 , $maxX1, $maxY1;
    $xSteps = ($maxX1 - $x01) / $xStep - 1; //определяем количество
//шагов по оси X
    $ySteps = ($maxY1 - $y01 ) / $yStep - 1; //определяем количество
//шагов по оси Y
//выводим сетку по оси X
    for ($i = 1; $i < $xSteps + 1; $i++) {
        imageline($im3, $x01 + $xStep * $i, $y01 , $x01 + $xStep * $i, $maxY1 - 1, $lightGrey);

    }
//выводим сетку по оси Y
    for ($i = 1; $i < $ySteps + 1; $i++) {
        imageline($im3, $x01 + 1, $maxY1 - $yStep * $i, $maxX1,
            $maxY1 - $yStep * $i, $lightGrey);

    }
}


function drawNumsNpsh($flowbpdstep = 200)
{
    global $im3, $grey, $font, $x01, $maxY1;
    $flowbpd = 0;

    $k = $maxY1;
    imagettftext($im3, 10, 0, 55, $k - 5, $grey, $font, "0");
    imagettftext($im3, 10, 0, 55, 49, $grey, $font, "1");
    imagettftext($im3, 10, 0, 55, 25, $grey, $font, "1");
    $k = $x01;
    for ($i = 1; $i <= 6; $i++) {
        imagettftext($im3, 10, 0, $k - 5, 100, $grey, $font, $flowbpd);
        $k += 120;
        $flowbpd += $flowbpdstep;
    }



}


function valueNpsh()
{
    global $im3 , $grey ,  $font;
    imagettftext($im3, 10, 0, 350, 120, $grey, $font, 'F');
    imagettftext($im3, 10, 0, 355, 120, $grey, $font, ' lowrate, m /d');
    imagettftext($im3, 6, 0, 419, 115, $grey, $font, '3');
    imagettftext($im3, 10, 0, 10, 25, $grey, $font, "NPSH");

}

function bildGraphNpsh($coord, $color){
    global $im3, $blue;
    $curves = array();
    $curves[] = new AkimaSpline();
    $colors[] = $blue;

//гр 1
    foreach($curves as $k => $curve){

        $curve->setCoords($coord);
        $r = $curve->process();
        $curveGraph = new Plot($r);

        $curveGraph->drawAALine($im3, $color, 75, 78);

    }


}
function ballNpsh($ballX,$ballY, $color){
    global $im3;

    imagefilledellipse($im3, $ballX, $ballY, 10, 10, $color);
}
function drawNpsh(){
    global $im3, $file3;
    imagepng($im3,  $file3, null, PNG_ALL_FILTERS);
    imagedestroy($im3);

}
