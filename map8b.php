<?php
    session_start(); //we need session for the log in thingy XD 
     define('DBINFO','mysql:host=localhost;dbname=webscrap');
    define('DBUSER','root');
    define('DBPASS','');

    function performQuery($query){
        $con = new PDO(DBINFO,DBUSER,DBPASS);
        $stmt = $con->prepare($query);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function fetchAll($query){
        $con = new PDO(DBINFO, DBUSER, DBPASS);
        $stmt = $con->query($query);
        return $stmt->fetchAll();
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

             $query = "select latitude,longitude from `accounts` WHERE latitude=$latitudeFrom OR longitude=$longitudeTo;";
                if(count(fetchAll($query))>0){
                	echo  "Final-"." "."Lat - ".$latitudeFrom."    "." Lng - ".$longitudeTo."<br>";
                  break;

         }

           

}
?>