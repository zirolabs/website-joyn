<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function tgl($date){
    /* ARRAY u/ hari dan bulan */
    $Hari = array ("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu",);
    $Bulan = array ("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
 /* Memisahkan format tanggal bulan dan tahun menggunakan substring */
 $tahun 	 = substr($date, 0, 4);
 $bulan 	 = substr($date, 5, 2);
 $tgl	 = substr($date, 8, 2);
 $waktu	 = substr($date,11, 5);
 $hari	 = date("w", strtotime($date));
 
 $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu." WIB";
 return $result;
 }

 //total untuk setiap row
 function total_jam($jam){
	$array1=explode(':',$jam);
	$total_jam=ltrim($array1[0],'0');
	$total_menit=ltrim($array1[1],'0');
	if($total_jam!=0&&$total_menit!=0){
		$result = $total_jam.' hours '.$total_menit.' minutes';
	}elseif($total_jam!=0){
		$result = $total_jam.' hours ';
	}elseif($total_menit!=0){
		$result = $total_menit.' minutes ';
	}else{
		$result = '-';
	}
	
	return $result;
 }

 // total semua row
 function SumTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}

function pukul($tanggal) {
	$array1	= explode(' ',$tanggal);
	$sisa = $array1[1];
	$jam   	= explode(':',$sisa);

    return $jam[0].':'.$jam[1].' WIB';
}
?>
