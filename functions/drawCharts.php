<?php
require_once __DIR__ . '/../libs/AkimaSpline.class.php';
require_once __DIR__ . '/../libs/Plot.class.php';
require_once __DIR__ .'/cleanDir.php';
require_once __DIR__ .'/drawImgWorkChar.php';
require_once __DIR__ .'/drawImgPerChar.php';
require_once __DIR__ .'/drawImgNPSH.php';
require_once __DIR__ .'/drawImgAxialLoad.php';
require_once __DIR__ .'/../data/dataImgPerChar.php';	//в этом файле хранятся значения для графика per
$graph=[
    'WorkChar' => [
        'graphH' =>[
            0 =>75,
            150=>100,
            378 => 116,
            563 =>66,
        ],
        'graphEff' =>[
            0 => 247,
            43 => 230,
            215=>198,
            301=>165,
            473=>0
        ],
        'graphPow' =>[
            0 => 0,
            110 => 165,
            301=>270,
            473 => 0
        ],
        'colors' =>[
            'colH' => $red,
            'colEff' => $blue,
            'colPow' => $green
        ]
    ],
    'npsh'=>[
        'coords'=>[
            80=>0,
            515=>33
        ],
        'color' => $blue
    ],
    'axialLoad'=>[
        'coords'=>[
            80 => 33,
            515 => 0
        ],
        'color' => $blue
    ]
];
$ball=[
    'work'=>[
        'X' =>  $maxX - 344,
        'Y' => $maxY - 165
    ],
    'per'=>[
        'X' =>242,
        'Y' => 263
    ],
    'npsh'=>[
        'X' =>380,
        'Y' =>60
    ],
    'axialLoad'=>[
        'X' => 380,
        'Y' =>62
    ],
    'color'=> $red
];


drawGridWork();
drawAxisesWork();
drawNumsWork();
valueWork();
drawValWork();
bildGraphWork($graph['WorkChar']['graphH'], $graph['WorkChar']['graphEff'],$graph['WorkChar']['graphPow'], $graph['WorkChar']['colors']);
ballWork($ball['work']['X'],$ball['work']['Y'], $ball['color']);
drawWork();

// график Частотная характеристика
drawGridPer();
drawAxisesPer();
drawNumsPer();
valuePer();
bildGraphPer($array, $сdred, $arr);
ballPer($ball['per']['X'], $ball['per']['Y'], $ball['color']);
drawPer();

// график NPSH
drawGridNpsh();
drawAxisesNpsh();
drawNumsNpsh();
valueNpsh();
bildGraphNpsh($graph['npsh']['coords'], $graph['npsh']['color']);
ballNpsh($ball['npsh']['X'], $ball['npsh']['Y'], $ball['color']);
drawNpsh();


// график Axial Loads
drawGridAxialLoad();
drawAxisesAxialLoad();
drawNumsAxialLoad();
valueAxialLoad();
bildGraphAxialLoad($graph['axialLoad']['coords'], $graph['axialLoad']['color']);
ballAxialLoad($ball['axialLoad']['X'], $ball['axialLoad']['Y'], $ball['color']);
drawAxialLoad();
?>
