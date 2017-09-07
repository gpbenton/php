<?php

require_once "iCalcreator.class.php";
$errorlog = "errors.log";
$aggconfig    = array( "unique_id" => "-//hewnsw//micalagg-",
                    "directory" =>".",
                    "filename"=>"icalmerge.ics" );

$aggcalendar = new vcalendar( $aggconfig);

if ($aggcalendar->useCachedCalendar()) {
    exit();
}

$calendars=array();

$listfile = fopen("urllist.txt", "r");
if ($listfile) {
  while (!feof($listfile)) {
    $calendars[]=fgets($listfile);
  }
  fclose ($listfile);
}

foreach ($calendars as &$inputcalendar) {

   $config = array ("unique_id" => "-//hewnsw//micalagg-",
                             "url" => $inputcalendar);

   $vcalendar = new vcalendar($config);
   $vcalendar->parse();
   while ( $event = $vcalendar->getComponent("vevent")) {
      $aggcalendar->setComponent($event);
   }

}

$aggcalendar->sort();

$aggcalendar->saveCalendar();

$aggcalendar->returnCalendar();

?>
