<?php

function isValidEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sqltime($t=null) {
	if($t == null) $t = time();
	return date("Y-m-d H:i:s",$t);
}

function number_ending ($number){
   $suff = array("th","st","nd","rd","th");
   $index = intval($number) % 10;
   if($index > 4){
      $index = 4;
   }elseif($index < 1){
      $index = 0;
   }
   return (number_format($number,0) . $suff[$index]);
}  

function explain_time($td) {
	
	if($td > 1000000000) $td = $td - time();
	
	if($td < 0) $past = true;
	else $past = false;
	
	$td = abs($td);
	
    if ($td > 60*60*24*365)  { $tn > round($td/(3600 * 24 * 365)); $tp = 'year'; }
    else if   ($td > 60*60*24*30)  { $tn = round($td/(3600 * 24 * 30)); $tp = 'month'; }
    else if   ($td > 60*60*24*7)  { $tn = round($td/(3600 * 24 * 7)); $tp = 'week'; }
    else if   ($td > 60*60*24 ) {  $tn = round($td/(3600 * 24)); $tp =  'day'; }
    else if   ($td > 60*60) { $tn = round($td/3600); $tp = 'hour'; }
    else if   ($td > 60) { $tn = round($td/60); $tp = 'minute'; }
    else if   ($td > 0) { $tn = $td; $tp =  'second'; }
    else return "just now";

    if($tn > 1) $tp = $tp . 's';


    return $tn . ' ' . $tp . (($past)?' ago':' from now');

}

function header_note($s,$ok) { // Message, then either success or failure
	$CI = &get_instance();
	
	$s = "<div id=header_note class='header_note ".(($ok)?'header_okay':'header_error')."'>".$s."</div>";
	
	$CI->session->set_userdata('session_note',$s);
}

function getCurrentlyOnlinePeople() {

	$CI = &get_instance();

	$people = $CI->db->select('id')->where('activity >',date('Y-m-d H:i:s',time()-20*60))->get('users')->result_array();
	
	$ps = array();
	foreach($people as $p) {
		$ps[] = new User($p['id']);
	}
	
	return $ps;	
}

function get_header_note() {
	$CI = &get_instance();
	
	$t = $CI->session->userdata('session_note');
	
	$CI->session->set_userdata('session_note','');
	
	return $t;
	
}

function isLoggedIn() {
	$CI = &get_instance();
	return $CI->session->userdata('loggedin');
}