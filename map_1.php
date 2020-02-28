
<?php
$mysqli = new mysqli("localhost","root","","webscrap");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
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

<?php
            
             $result = $mysqli->query("SELECT lat,lng FROM accounts");
          
          

        
      


            ?>
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
	 <?php if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '{lng:'.$row['lng'].','.'lat:'.$row['lat'].'},';
            }
        }
        ?>
        
];




   var BucaramangaPolygon = new google.maps.Polygon({
    paths: BucaramangaDelimiters,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 3,
    fillColor: '#FF0000',
    fillOpacity: 0.35
});




// Draw the polygon on the desired map instance
BucaramangaPolygon.setMap(map);



	

	 
	} 
	</script> 
	<script async defer 
	src= 
"https://maps.googleapis.com/maps/api/js?key=AIzaSyC7A7SxsYrrTJG8Aj3r-xMt1bGL00qJiLM&libraries=visualization&callback=initMap"> 
	</script> 
</body> 
</html> 
