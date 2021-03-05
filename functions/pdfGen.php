<?php
define('FPDF_FONTPATH', __DIR__.'/../font/');
const IMG = __DIR__ . '/../tmp_img';
require_once __DIR__.'/../libs/tfpdf.php';
require_once __DIR__.'/../data/getPdfData.php';
require_once __DIR__."/drawCharts.php";
require_once __DIR__."/../data/dbPumps.php";

$width = 508;
$height = 504;
$pdf = new tFPDF('P','mm',array($width,$height)); //задаём значения листа в миллиметрах и ориентацию. Значения узнал, пересчитав пиксели в миллиметры (оригинал 1920х1905)
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('ArialReg','','arial.ttf',true);
$pdf->AddFont('ArialBd','','arialbd.ttf',true);
$pdf->SetFont('ArialReg','',13);

//Начинаем печатать текст
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetXY($width*167/1920,$height*32/1905);			//здесь и далее отношение переменной к исходным размерам считал про пропорции (1920 и [значение, измеренное в исходнике] <=> ([ширина] и [требуемое значение]), длина по аналогии
$pdf->Write(4,$pdf_data['main_title']);
$pdf->SetXY($width*167/1920,$height*69/1905);
$pdf->Write(4,$pdf_data['adress']);
$pdf->SetXY($width*167/1920,$height*89/1905);
$pdf->Write(4,$pdf_data['requisites']);
$pdf->SetXY($width*167/1920,$height*123/1905);
$pdf->Write(4,$pdf_data['telephones']);
$pdf->SetXY($width*167/1920,$height*144/1905);
$pdf->SetTextColor($pdf_data['text_secondary'][0], $pdf_data['text_secondary'][1], $pdf_data['text_secondary'][2]);
$pdf->Write(4,$pdf_data['email'].' ');
$pdf->Write(4, $pdf_data['site'], 'https://site.com');
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetXY($width*167/1920,$height*207/1905);
$pdf->SetFont('ArialBd','',18);
$pdf->Write(4,$pdf_data['report_title']);
$pdf->SetXY($width*167/1920,$height*266/1905);
$pdf->SetTextColor($pdf_data['text_secondary'][0], $pdf_data['text_secondary'][1], $pdf_data['text_secondary'][2]);
$pdf->Write(5,$pdf_data['pump_selected'].' - ' . $db_pump['title']);

//левая секция
$pdf->SetFont('ArialBd','',13);
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetXY($width*167/1920,$height*303/1905);
$pdf->SetFillColor(245,248,248);
$pdf->Cell($width*373/1920,$height*36/1905,' ' . $pdf_data['working_params'].':',0,0,'L',true);
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*167/1920+2,$height*349/1905 ); 
$pdf->Write(4, $pdf_data['head'].': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, '35');
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' '.$pdf_data['unit_length']);

$pdf->SetXY($width*167/1920+2,$height*373/1905);
$pdf->Write(4, $pdf_data['consump'].': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, '450');
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_length']);
$pow_x = $pdf -> GetX();
$pdf->SetFont('ArialReg','', 8);
$pdf->SetXY($pow_x, $height*370/1905);
$pdf->Write(4, '3');
$day_x = $pdf -> GetX();
$pdf->SetFont('ArialReg','', 13);
$pdf->SetXY($day_x, $height*373/1905);
$pdf->Write(4, '/' . $pdf_data['unit_day']);

$pdf->SetXY($width*167/1920+2,$height*397/1905);
$pdf->Write(4, $pdf_data['inp_pres'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, '000');
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' '.$pdf_data['unit_length']);

$pdf->SetXY($width*167/1920+2,$height*421/1905);
$pdf->Write(4, $pdf_data['freq'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, $db_pump['frequency']);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' '.$pdf_data['unit_freq_1']);

//секция посередине
$pdf->SetFont('ArialBd','',13);
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetXY($width*660/1920,$height*303/1905);
$pdf->SetFillColor(245,248,248);
$pdf->Cell($width*373/1920,$height*36/1905,' ' . $pdf_data['fluid_params'] . ':',0,0,'L',true);
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*660/1920 + 2,$height*349/1905 ); 
$pdf->Write(4, $pdf_data['fluid_type'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, '000'); 
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*660/1920 + 2,$height*373/1905);
$pdf->Write(4, $pdf_data['density'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, '000');
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_density']);
$pow_x = $pdf -> GetX();
$pdf->SetFont('ArialReg','', 8);
$pdf->SetXY($pow_x, $height*370/1905);
$pdf->Write(4, '3');							//поставил степень цифрой, можно рассмотреть добавление символа как значка
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*660/1920 + 2,$height*397/1905);
$pdf->Write(4, $pdf_data['temp'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 0);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_temp']);		//значок градуса

$pdf->SetXY($width*660/1920 + 2,$height*421/1905);
$pdf->Write(4, $pdf_data['ehf_content'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 500);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_ehf_content_1'] . ' (');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 175);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_ehf_content_2'] . ')');

//секция справа
$pdf->SetFont('ArialBd','',13);
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetXY($width*1155/1920,$height*303/1905);
$pdf->SetFillColor(245,248,248);
$pdf->Cell($width*373/1920,$height*36/1905,' ' . $pdf_data['pump_params'] . ':',0,0,'L',true);
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*1155/1920 + 2,$height*349/1905 ); 
$pdf->Write(4, $pdf_data['freq'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 50);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_freq_1'] . ' (');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 2910);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_speed_d'] . ')');

$pdf->SetXY($width*1155/1920 + 2,$height*373/1905);
$pdf->Write(4, $pdf_data['stage'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 'ЭЦН');
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*1155/1920 + 2,$height*397/1905);
$pdf->Write(4, $pdf_data['amount'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 50);
$pdf->SetFont('ArialReg','',13);

$pdf->SetXY($width*1155/1920 + 2,$height*421/1905);
$pdf->Write(4, $pdf_data['cav_reserve'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 10);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_length']);

$pdf->SetXY($width*1155/1920 + 2,$height*445/1905);
$pdf->Write(4, $pdf_data['power_u'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 215);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_power']);

$pdf->SetXY($width*1155/1920 + 2,$height*469/1905);
$pdf->Write(4, $pdf_data['eff'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 75);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, '%');

$pdf->SetXY($width*1155/1920 + 2,$height*493/1905);
$pdf->Write(4, $pdf_data['axial_force'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 3500);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_force']);

$pdf->SetXY($width*1155/1920 + 2,$height*517/1905);
$pdf->Write(4, $pdf_data['pres_corp_break'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 210);
$pdf->SetFont('ArialReg','',13);
$pdf->Write(4, ' ' . $pdf_data['unit_length']);

$pdf->SetXY($width*1155/1920 + 2,$height*541/1905);
$pdf->Write(4, $pdf_data['shaft_type'] . ': ');
$pdf->SetFont('ArialBd','',13);
$pdf->Write(4, 's11');

//рисуем таблицу с выбранным насосом, Multicell автоматически переносит курсор на новую строку, так что приходится делать это вручную, каждый раз перенося "курсор" методом SetXY
$pdf->SetDrawColor($pdf_data['borders'][0], $pdf_data['borders'][1], $pdf_data['borders'][2]);				//цвет границ ячеек
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->SetFontSize(13);
$pdf->SetXY($width*167/1920,$height*651/1905);
$pdf->Cell($width*200/1920,$height*75/1905, $pdf_data['stage'], 'LTB',0,'C',true); //для названия ступени возьмём побольше ширины
$newcell_x = $pdf->GetX();
$pdf->MultiCell($width*120/1920, $height*37.5/1905, $pdf_data['amount'] . "\n" . $pdf_data['stages'], 'TB', 'C', true); //здесь 37.5 это 75/2, т к Multicell делает + 1 ячейку ниже если текст не влезает и помещает туда текст
$pdf->SetXY($newcell_x + $width*120/1920, $height*651/1905);			//отсюда далее перемещаемся на нужные коорд-ты, чтобы это сделать, нужно учесть длину предыдущего столбца (если сделать все столбцы одинаковые, таблица просто не поместится на лист)
$width_freq = $width*130/1920;
$pdf->MultiCell($width_freq, $height*37.5/1905, $pdf_data['freq'] . ",\n" . $pdf_data['unit_freq_1'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq, $height*651/1905);
$width_speed = $width*140/1920;
$pdf->MultiCell($width_speed,$height*25/1905, $pdf_data['speed'] . "\n" . $pdf_data['rotations'] . ",\n" . $pdf_data['unit_speed_u'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed, $height*651/1905);
$width_power = $width*140/1920;
$pdf->MultiCell($width_power,$height*25/1905, $pdf_data['consumable'] . "\n" . $pdf_data['power_d'] . ",\n" . $pdf_data['unit_power'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power, $height*651/1905);
$width_eff = $width*120/1920;
$pdf->MultiCell($width_eff,$height*37.5/1905, $pdf_data['eff'] . ",\n%",'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff, $height*651/1905);
$width_pres = $width*173/1920; 
$pdf->MultiCell($width_pres,$height*25/1905, $pdf_data['requiered'] . "\n" . $pdf_data['inp_pres_1'] . ",\n" . $pdf_data['unit_length'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff + $width_pres, $height*651/1905);
$width_force = $width*140/1920; 
$pdf->MultiCell($width_force,$height*37.5/1905, $pdf_data['axial_force'] . ",\n" . $pdf_data['unit_force'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff + $width_pres + $width_force, $height*651/1905);
$width_length = $width*110/1920;
$pdf->MultiCell($width_length,$height*25/1905, $pdf_data['length'] . "\n" . $pdf_data['pumps'] . ",\n" . $pdf_data['unit_length'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff + $width_pres + $width_force + $width_length, $height*651/1905);
$width_break = $width*170/1920; 
$pdf->MultiCell($width_break,$height*25/1905,$pdf_data['pres_u'] . "\n" . $pdf_data['corp_break'] . ",\n" . $pdf_data['unit_length'],'TB','C',true);
$pdf->SetXY($newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff + $width_pres + $width_force + $width_length + $width_break, $height*651/1905);
$width_shaft = $width*130/1920; 
$pdf->MultiCell($width_shaft,$height*75/1905,$pdf_data['shaft_type'],'TBR','C',true);

//заполняем значения
$pdf->SetX($width*167/1920);
$pdf->Cell($width*200/1920, $height*47/1905,$db_pump['title'],'LB',0,'C');
$pdf->SetFont('ArialReg','',13);
$pdf->Cell($width*120/1920, $height*47/1905, $db_pump['amount_stage'],'B',0,'C');
$pdf->SetFont('ArialBd','',13);
$pdf->Cell($width_freq, $height*47/1905, $db_pump['frequency'],'B',0,'C');
$pdf->Cell($width_speed, $height*47/1905, $db_pump['rotation_speed'],'B',0,'C');
$pdf->Cell($width_power, $height*47/1905, $db_pump['power_using'],'B',0,'C');
$pdf->SetFont('ArialReg','',13);
$pdf->Cell($width_eff, $height*47/1905, $db_pump['efficiency'],'B',0,'C');
$pdf->Cell($width_pres, $height*47/1905, '0,1','B',0,'C');
$pdf->Cell($width_force, $height*47/1905, '3500','B',0,'C');
$pdf->Cell($width_length, $height*47/1905, $db_pump['length'],'B',0,'C');
$pdf->Cell($width_break, $height*47/1905, '210','B',0,'C');
$pdf->Cell($width_shaft, $height*47/1905, 's11','BR',1,'C');

 //выводим текущую дату и эмейл
$pos_date = $newcell_x + $width*120/1920 + $width_freq + $width_speed + $width_power + $width_eff + $width_pres + $width_force + $width_length + $width_break + $width_shaft - $width*200/1920;		//считаем позицию с учётом отступа справа (то есть делаем выравнивание правой границы наших надписей по правой границе таблицы со значениями, которая выше)
$pdf->SetXY($pos_date,$height*175/1905);
$pdf->SetFont('ArialBd','',14);		//ставим 14, а не 13, т к в оригинале шрифт 18, а не 16
$pdf->Cell($width*200/1920,$height*20/1905,date('j.m.y'),0,1,'R',false);		//день без "0", т е не 05, а 5
$pdf->SetTextColor($pdf_data['text_secondary'][0], $pdf_data['text_secondary'][1], $pdf_data['text_secondary'][2]);
$pdf->SetX($pos_date);
$pdf->Cell($width*200/1920,$height*20/1905,$pdf_data['user_email'],0,1,'R',false); 

//$pdf->Image(__DIR__ . '/../img/logo1.png', $width*1670/1920, 10, 18);		//изображение
//$pdf->Image(__DIR__ . '/../img/logoOutro.png', $width*1120/1920, 450 , 175);		//изображение

//пишем подписи к графикам
$pdf->SetXY($width*167/1920,$height*865/1905);
$pdf->SetFont('ArialBd','',13);
$pdf->SetTextColor($pdf_data['text_main'][0], $pdf_data['text_main'][1], $pdf_data['text_main'][2]);
$pdf->Write(4, $pdf_data['work_char']);
$pdf->Image($file1, 40, 240); //IMG.'\img1.png'
$pdf->SetXY($width*1090/1920,$height*865/1905);
$pdf->Write(4, $pdf_data['freq_char']);
$pdf->Image($file2, $width*1040/1920,240);//IMG.'\img1.png'
$pdf->SetXY($width*500/1920,$height*1350/1905);
$pdf->Write(4, $pdf_data['NPSH']);
$pdf->Image($file3, $width*150/1920,365);//IMG.'\img1.png'
$pdf->SetXY($width*480/1920,$height*1520/1905);
$pdf->Write(4, $pdf_data['axial_loads']);
$pdf->Image($file4, $width*150/1920,411); //IMG.'\img4.png'

//Выводим pdf в файл к нам и к пользователю на просмотр с возможностью сохранения (имена разные)
$timeshtamp = time();
$id_user = 123;
//$pdf->Output('F',"C:\projects\\{$timeshtamp}_report_{$id_user}.pdf");		//в файл
$pdf->Output('I',$db_pump['title'] . '.pdf', true);		//отдаём пользователю

//чистим папку с графиками
cleanDir(IMG);
