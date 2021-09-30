<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function options($src, $id, $ref_val, $text_field){
	$options = '';
	foreach ($src->result() as $row) {
		$opt_value	= $row->$id;
		$text_value	= $row->$text_field;
		
		if ($row->$id == $ref_val) {
			$options .= '<option value="'.$opt_value.'" selected>'.$text_value.'</option>';
		}
		else {
			$options .= '<option value="'.$opt_value.'">'.$text_value.'</option>';
		}
	}
	return $options;
}

function password($raw_password) {
	return MD5('*123#'.$raw_password);
}

function get_month($bln){
	switch ($bln){
		case 1: return "Jan"; break;
		case 2:	return "Feb"; break;
		case 3:	return "Mar"; break;
		case 4:	return "Apr"; break;
		case 5:	return "May"; break;
		case 6:	return "Jun"; break;
		case 7:	return "Jul"; break;
		case 8:	return "Aug"; break;
		case 9:	return "Sep"; break;
		case 10: return "Oct"; break;
		case 11: return "Nov"; break;
		case 12: return "Dec"; break;
	}
}

function get_month_val($bln){
	switch ($bln){
		case "Jan": return 01; break;
		case "Feb":	return 02; break;
		case "Mar":	return 03; break;
		case "Apr":	return 04; break;
		case "May":	return 05; break;
		case "Jun":	return 06; break;
		case "Jul":	return 07; break;
		case "Aug":	return 08; break;
		case "Sep":	return 09; break;
		case "Oct": return 10; break;
		case "Nov": return 11; break;
		case "Dec": return 12; break;
	}
}

function tgl_sql($date){
	$exp = explode('-',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
	}
	return $date;
}




/* End of file gmf_helper.php */
/* Location: ./application/helpers/gmf_helper.php */