<?php
$mysqli = new mysqli("localhost","root","","webscrap");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>

<?php

$formattedAddrFrom = $_GET['from'];
$formattedAddrTo = $_GET['to'];

 $addr1 = str_replace(' ', '+', $formattedAddrFrom);
 $addr2 = str_replace(' ', '+', $formattedAddrTo);

$api = "https://maps.googleapis.com/maps/api/directions/json?origin='.$addr1.'&destination='.$addr2.'&key=AIzaSyC7A7SxsYrrTJG8Aj3r-xMt1bGL00qJiLM";
$samp = file_get_contents($api);

$samp1 = json_decode($samp);
$elementCount  = count($samp1);

for($i=0;$i<$elementCount;$i++)
{
 $latitudeFrom = $samp1->routes[0]->legs[0]->steps[$i]->start_location->lat;
  $longitudeTo = $samp1->routes[0]->legs[0]->steps[$i]->start_location->lng;
   $latitudeFrom1 = $samp1->routes[0]->legs[0]->steps[$i]->end_location->lat;
   $longitudeTo1 = $samp1->routes[0]->legs[0]->steps[$i]->end_location->lng;



 echo  "Lat - ".$latitudeFrom."    "." Lng - ".$longitudeTo."<br>".$latitudeFrom1."<br>".$longitudeTo1."<br>";

             
           

}
?>