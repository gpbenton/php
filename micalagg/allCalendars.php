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

$calendars = array("http://applications.huntingdonshire.gov.uk/applications/RefuseCalendarMVC/Home/Download/cal100090110283.ics",
             "http://www.espncricinfo.com/england-v-south-africa-2017/content/series/1031417.ics?template=ical",
             "http://www.gov.uk/bank-holidays/england-and-wales.ics"
             );



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
