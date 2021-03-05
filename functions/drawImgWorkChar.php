<?php
define('GRAPH_WIDTH', 800);
define('GRAPH_HEIGHT', 450);
$imgHeight = GRAPH_HEIGHT + 10;
$im = imagecreatetruecolor(GRAPH_WIDTH + 50, $imgHeight);
$font = __DIR__ . "/../font/unifont/arial.ttf";

//цвета
$white = ImageColorAllocate ($im, 255, 255, 255);
$black = ImageColorAllocate ($im, 0, 0, 0);
$red = ImageColorAllocate ($im, 255,65,65);
$green = ImageColorAllocate ($im, 11,132,9);
$blue = ImageColorAllocate ($im, 22,13,215);
$yellow = ImageColorAllocate ($im, 235,122,9);
$grey = ImageColorAllocate ($im, 125,125,125);
$lightGrey = ImageColorAllocate ($im, 231,231,231);
$blueGrey = ImageColorAllocate ($im, 79,113,161);
$lightRed = ImageColorAllocate ($im, 231,97,101);
$lightGreen = ImageColorAllocate ($im, 155,187,89);


//называем файл
//$filename1 = pow(mt_rand(1,mt_getrandmax()),2) * mt_rand(1, 999);
$filename1 = uniqid();
$file1 = __DIR__ . "/../tmp_img/chart1_" . $filename1 . ".png";

imagefill($im, 0, 0, $white);

$x0=75; //начало оси координат по X
$y0=75;//начало оси координат по Y
$maxX=GRAPH_WIDTH - $x0; //максимальное значение оси
//координат по X в пикселах
$maxY=GRAPH_HEIGHT-$y0; //максимальное значение оси
//функция для осей
function drawAxisesWork(){
    global $im,$grey,$red, $lightGrey,$x0,$y0,$maxX,$maxY;

    imageline($im, $x0, $maxY, $maxX, $maxY, $lightGrey);


    //рисуем ось Y
    imageline($im, $x0, $y0, $x0, $maxY, $grey);
    imageline($im, $maxX, $y0, $maxX, $maxY, $grey);
    //рисуем другие линии
    imageline($im, 805, $y0-5, 805, $maxY, $grey);
    imageline($im, 765, $y0-5, 765,$maxY, $grey);
    imageline($im, 45  , $y0-5, 45, $maxY, $grey);
    imageline($im, 290    , $y0, 290, $maxY, $grey);
    imageline($im, 463    , $y0, 463, $maxY, $grey);
    $k = $y0;
    for($i=1; $i <=5; $i++){
        imageline($im, 37  , $k, 45, $k, $grey);
        $k+=75;
    }
    $k = $maxY;
    for($i=1; $i <=11; $i++){
        imageline($im, 813  , $k, 805, $k, $grey);

        $k -= 29.5;
    }
    $k = $maxY;
    for ($i=1; $i <=6; $i++){

        imageline($im, 773  , $k, 765, $k, $grey);
        $k -=59;

    }

}


function drawGridWork($xStep=43.3, $yStep = 33.25){
    global $im,$lightGrey,$x0,$y0,$maxX,$maxY;
    $xSteps=($maxX-$x0)/$xStep-1; //определяем количество
//шагов по оси X
    $ySteps=($maxY-$y0)/$yStep-1; //определяем количество
//шагов по оси Y
//выводим сетку по оси X
    for($i=1;$i<$xSteps+1;$i++){
        imageline($im, $x0+$xStep*$i, $y0, $x0+$xStep*$i,$maxY-1, $lightGrey);

    }
//выводим сетку по оси Y
    for($i=1;$i<$ySteps+1;$i++){
        imageline($im, $x0+1, $maxY-$yStep*$i, $maxX,
            $maxY-$yStep*$i, $lightGrey);

    }
}


function drawNumsWork($mstep = 4, $ftstep = 10, $flowbpdstep = 200, $flowmdsstep = 20, $kwstep = 0.2, $effstep = 10){
    global $im,$blue, $grey,$green, $red, $font,$x0, $maxY, $maxOX;
    $m = 0;
    $ft = 0;
    $flowbpd = 0;
    $flowmd = 0;
    $kw = 0;
    $eff = 0;
    $k = $maxY;
    for ($i=1; $i <=7; $i++){
        if($ft==0){
            imagettftext($im, 10, 0, 60 , $k-5, $blue, $font, $ft);
        }else{
            imagettftext($im, 10, 0, 55 , $k-5, $blue, $font, $ft);
        }
        $k -=48;
        $ft += $ftstep;
    }
    $k = $x0;
    for ($i=1; $i <=6; $i++){
        imagettftext($im, 10, 0, $k-5 , 395, $grey, $font, $flowbpd);
        $k +=120;
        $flowbpd += $flowbpdstep;
    }
    $flowbpd -= $flowbpdstep;
    $maxOX = $flowbpd;
    $k = $x0;
    for ($i=1; $i <=8; $i++){
        imagettftext($im, 10, 0, $k-5 , 65, $grey, $font, $flowmd);
        $k +=82.5;
        $flowmd += $flowmdsstep;
    }
    $k = $maxY;
    for($i=1; $i <=5; $i++){
        imagettftext($im, 10, 0, 20 , $k+5, $blue, $font, $m);
        imagettftext($im, 10, 0, 730 , $k+5, $red, $font, ($m /10));
        $k-=75;
        $m+=$mstep;
    }
    $k = $maxY;
    for ($i=1; $i <=6; $i++){
        imagettftext($im, 10, 0, 820 , $k+5, $green, $font, $eff);
        imagettftext($im, 10, 0, 780 , $k+5, $red, $font, $kw);
        $k -=59;
        $eff += $effstep;
        $kw += $kwstep;
    }

}



function valueWork(){
    global $im,$green, $blue, $red,$grey,$font;
    imagettftext($im, 10, 0, 350, 425, $grey, $font, 'F');
    imagettftext($im, 10, 0, 355, 425, $grey, $font, ' lowrate, bpd');
    imagettftext($im, 10, 0, 350, 25, $grey, $font, 'F');
    imagettftext($im, 10, 0, 355, 25, $grey, $font, ' lowrate, m /d');
    imagettftext($im, 6, 0, 419, 20, $grey, $font, '3');
    imagettftext($im, 10, 0, 800, 50, $green, $font, 'E');
    imagettftext($im, 10, 0, 805, 50, $green, $font, ' ff.%');
    imagettftext($im, 10, 0, 770, 50, $red, $font, 'k');
    imagettftext($im, 10, 0, 773, 50, $red, $font, ' W');
    imagettftext($im, 10, 0, 730, 50, $red, $font, 'hp');
    imagettftext($im, 10, 0, 20, 50, $blue, $font, 'm');
    imagettftext($im, 10, 0, 55, 50, $blue, $font, 'ft');
}

function drawValWork($stren = 90){
    global $im,$yellow, $white,$x0, $maxX,$font;
    if($stren < 75 || $stren > 375){
        die('error');
    }
    imageline($im, $x0, $stren, $maxX, $stren, $yellow);
    imagefilledrectangle($im,620,$stren-8,700,$stren+8,$yellow);
    imagettftext($im, 7, 0, 626 , $stren+4, $white, $font, "Прочность вала");
}
function bildGraphWork($testCoords, $testCoords1, $testCoords2, $color){

    global $im,$grey,$blue,$green,$red,$x0,$y0,$maxX,$maxY, $maxOX;
/*  зачатки правильного скалирования графиков (x сделан по макс шагу)
    $workX = $maxX - $x0;
    $workY = $maxY - $y0;
    debug($workY);
    $keys = array();
    $values = array();
    $stepN = $workX / $maxOX;
    foreach ($testCoords as $key =>$value){
        $key *= $stepN;
        array_push ( $keys, $key);
        array_push($values, $value);
    }

    $newCord = array_combine($keys, $values);
*/
    $curves = array();
    $curves[] = new AkimaSpline();


    //гр 1
    foreach($curves as $k => $curve){

        $curve->setCoords($testCoords);
        $r = $curve->process();
        $curveGraph = new Plot($r);
        $curveGraph->drawAALine($im, $color['colH'], 75, 375);

    }

    //гр2
    $curves1 = array();
    $curves1[] = new AkimaSpline();
    //строим граф
    foreach($curves1 as $q => $curve1){
        $curve1->setCoords($testCoords1);
        $w = $curve1->process();
        $curveGraph1 = new Plot($w);
        $curveGraph1->drawAALine($im, $color['colEff'], 75, 375);
    }

    //гр3
    $curves2 = array();
    $curves2[] = new AkimaSpline();
    $colors2[] = $green;
    //строим граф
    foreach($curves2 as $e => $curve2){
        $curve2->setCoords($testCoords2, 1);
        $t = $curve2->process();
        $curveGraph2 = new Plot($t);
        $curveGraph2->drawAALine($im, $color['colPow'], 75, 375);
    }
}
function ballWork($ballX,$ballY, $color){
    global $im, $grey,$red, $maxY,$x0,$y0;

    imagedashedline (  $im, $x0 , $ballY , $ballX-5, $ballY , $grey);
    imagedashedline (  $im, $ballX , $y0 , $ballX, $maxY , $red);
    imagefilledellipse($im, $ballX, $ballY, 10, 10, $color);
}
function drawWork(){
    global  $im, $file1;

    imagepng($im,  $file1, null, PNG_ALL_FILTERS);
    imagedestroy($im);

}

