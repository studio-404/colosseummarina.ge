<?php

defined('DIR') OR exit;

$c['output.buffering'] = NULL;

$c['section.types.list_ids'] = array(8, 9, 10, 11);

$c['section.home'] = 1;
$c['section.contact'] = 11;
$c['section.sitemap'] = 1075;
$c['section.search'] = 1074;

$c['section.parameters'] = array();

$c['section.site.undeletable'] = array(
    $c['section.default'],
    $c['section.search'],
    $c['section.contact'],
    $c['section.sitemap']
);

$c['contact.email'] = 'info@justice.ge';

$c['month.names'] = array (
	"1"  	=> array("ge" => "იანვარი", 		"en" => "January"),
	"2"  	=> array("ge" => "თებერვალი", 	"en" => "February"),
	"3"  	=> array("ge" => "მარტი", 		"en" => "March"),
	"4"  	=> array("ge" => "აპრილი", 		"en" => "April"),
	"5"  	=> array("ge" => "მაისი", 		"en" => "May"),
	"6"  	=> array("ge" => "ივნისი", 		"en" => "June"),
	"7"  	=> array("ge" => "ივლისი", 		"en" => "July"),
	"8"  	=> array("ge" => "აგვისტო", 		"en" => "August"),
	"9"  	=> array("ge" => "სექტემბერი", 	"en" => "September"),
	"10"  	=> array("ge" => "ოქტომბერი", 	"en" => "October"),
	"11"  	=> array("ge" => "ნოემბერი", 		"en" => "November"),
	"12"  	=> array("ge" => "დეკემბერი", 	"en" => "December"),
);

$c['day.names'] = array (
	"1"  	=> array("ge" => "ორშაბათი", 		"en" => "Monday"),
	"2"  	=> array("ge" => "სამშაბათი", 		"en" => "Tuesday"),
	"3"  	=> array("ge" => "ოთხშაბათი", 	"en" => "Wednesday"),
	"4"  	=> array("ge" => "ხუთშაბათი", 	"en" => "Thursday"),
	"5"  	=> array("ge" => "პარასკევი", 		"en" => "Friday"),
	"6"  	=> array("ge" => "შაბათი", 		"en" => "Saturday"),
	"7"  	=> array("ge" => "კვირა", 		"en" => "Sunday"),
);

$c['day.shortnames'] = array (
	"1"  	=> array("ge" => "ორშ", 	"en" => "Mon"),
	"2"  	=> array("ge" => "სამ", 		"en" => "Tue"),
	"3"  	=> array("ge" => "ოთხ", 	"en" => "Wed"),
	"4"  	=> array("ge" => "ხუთ", 		"en" => "Thu"),
	"5"  	=> array("ge" => "პარ", 		"en" => "Fri"),
	"6"  	=> array("ge" => "შაბ", 		"en" => "Sat"),
	"7"  	=> array("ge" => "კვი", 		"en" => "Sun"),
);

return $c;
