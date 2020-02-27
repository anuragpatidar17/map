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


for($i=0;$i<20;$i++)
{
 $latitudeFrom = $samp1->routes[0]->legs[0]->steps[$i]->start_location->lat;
 $longitudeTo = $samp1->routes[0]->legs[0]->steps[$i]->start_location->lng;

 echo  "Lat - ".$latitudeFrom."    "." Lng - ".$longitudeTo."<br>";

               $result = $mysqli->query("select lat,lng from accounts WHERE lat=$latitudeFrom OR lng=$longitudeTo");
                $row = mysqli_num_rows($result);
                if($row >0){
                	echo  "Final-"." "."Lat - ".$latitudeFrom."    "." Lng - ".$longitudeTo."<br>";
                  break;

         }

           

}
?>