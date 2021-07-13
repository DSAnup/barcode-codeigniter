<?php
/**
* 
*/
class en2bn 
{
	public function bn2enNumber($number) {
        $search_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $replace_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $bn_number = str_replace($replace_array, $search_array, $number);
        return $bn_number;
    }
}

?>