
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


<!DOCTYPE html> 
<html> 
<head> 
	<style> 
	#map { 
		height: 600px; 
		width: 100%; 
	} 
	</style> 
</head> 
<body> 
	


	<div id="map"></div> 
	<script> 
	function initMap() { 

    var map = new google.maps.Map(document.getElementById('map'), {
    center: {
        lat:  23.0225716,
        lng: 72.5713058
    },
    zoom: 13,
    mapTypeId: 'roadmap'
});
        
	var BucaramangaDelimiters = [
   { lng: 72.5713058, lat: 23.0225716 },
{ lng: 72.5732506, lat: 23.0226052 },
{ lng: 72.5773205, lat: 23.022361 },
{ lng: 72.5988695, lat: 23.0233381 },
{ lng: 72.59891, lat: 23.0227283 },
{ lng: 72.6069871, lat: 23.0207676 },
{ lng: 72.6357354, lat: 23.0202093 },
{ lng: 72.6413048, lat: 23.0210173 },
{ lng: 72.672673, lat: 23.0249709 },
{ lng: 73.4551777, lat: 22.8032463 }
];

var BucaramangaDelimiters1 = [
{ lng: 73.6724156, lat: 22.7879818 },
{ lng: 74.5676515, lat: 22.8025399 },
{ lng: 74.6478891, lat: 22.7798812 },
{ lng: 74.7525221, lat: 22.7546983 },
{ lng: 74.9319091, lat: 22.6799837 },
{ lng: 75.5981129, lat: 22.6833069 },
{ lng: 75.7802845, lat: 22.6933571 },
{ lng: 75.8243435, lat: 22.7073135 },
{ lng: 75.8405248, lat: 22.713139 },
{ lng: 75.8405427, lat: 22.7151784 }
];


		
   var BucaramangaPolygon = new google.maps.Polygon({
    paths: BucaramangaDelimiters,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 3,
    fillColor: '#FF0000',
    fillOpacity: 0.35
});


   var BucaramangaPolygon1 = new google.maps.Polygon({
    paths: BucaramangaDelimiters1,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 3,
    fillColor: '#FF0000',
    fillOpacity: 0.35
});


// Draw the polygon on the desired map instance
BucaramangaPolygon.setMap(map);
BucaramangaPolygon1.setMap(map);


	

	 
	} 
	</script> 
	<script async defer 
	src= 
"https://maps.googleapis.com/maps/api/js?key=AIzaSyC7A7SxsYrrTJG8Aj3r-xMt1bGL00qJiLM&libraries=visualization&callback=initMap"> 
	</script> 
</body> 
</html> 
