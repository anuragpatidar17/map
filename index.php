<?php
$mysqli = new mysqli("localhost","root","","webscrap");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<title>Map</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--===============================================================================================-->


<?php
            
             $result = $mysqli->query("SELECT * FROM accounts");
          
          
  $result2 = $mysqli->query("SELECT * FROM accounts");
        
      


            ?>



    <script>
    	  
  function calculateRoute(from, to) {
   
     var colors = ['#2AB1D6'];
     var bounds = new google.maps.LatLngBounds();
    var myOptions = {
      zoom: 10,
      center: new google.maps.LatLng(22.7073135,75.8243435),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      
};

    // Draw the map
    var mapObject = new google.maps.Map(document.getElementById("map"), myOptions);


    var directionsService = new google.maps.DirectionsService();
   
    var directionsRequest = {
      origin: from,
      destination: to,
      provideRouteAlternatives: true,
      travelMode: google.maps.DirectionsTravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC
    };


 



    directionsService.route(
      directionsRequest,
      function(response, status)
          {

            if (status == google.maps.DirectionsStatus.OK)
            {
              for(var i=0,len=response.routes.length;i<len;i++)
              {
              new google.maps.DirectionsRenderer({
                map: mapObject,
                directions: response,
                routeIndex: i,
                  polylineOptions: {
                strokeColor: colors[0]
              },
                
                
              });
            }
          }
        else
          $("#error").append("Unable to retrieve your route<br />");
      }
    );


 var markers = [
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


               $result = $mysqli->query("select lat,lng,name from accounts WHERE lat=$latitudeFrom OR lng=$longitudeTo");
                if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '["'.$row['name'].'", '.$row['lat'].', '.$row['lng'].'],';
            }
        }

         }
?>
];

     var infoWindowContent = [
        <?php if($result2->num_rows > 0){
            while($row = $result2->fetch_assoc()){ ?>
                ['<div class="info_content">' +
                '<h3><?php echo $row['name']; ?></h3>' +
                '<p><?php echo $row['info']; ?></p>' + '</div>'],
        <?php }
        }
        ?>
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

     for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: mapObject,
            title: markers[i][0]
        });

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        }

         var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(10);
        google.maps.event.removeListener(boundsListener);
    });



       }


  $(document).ready(function() {
    // If the browser supports the Geolocation API
    
    if (typeof navigator.geolocation == "undefined") {
      $("#error").text("Your browser doesn't support the Geolocation API");
      return;
    }

    $("#from-link, #to-link").click(function(event) {
      event.preventDefault();
      var addressId = this.id.substring(0, this.id.indexOf("-"));

      navigator.geolocation.getCurrentPosition(function(position) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          "location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
        },
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK)
            $("#" + addressId).val(results[0].formatted_address);
          else
            $("#error").append("Unable to retrieve your address<br />");
        });
      },
      function(positionError){
        $("#error").append("Error: " + positionError.message + "<br />");
      },
      {
        enableHighAccuracy: true,
        timeout: 10 * 1000 // 10 seconds
      });
    });

    $("#calculate-route").submit(function(event) {
      event.preventDefault();
      calculateRoute($("#from").val(), $("#to").val());
      
    });
  });




</script>
<script>
function scrollWin() {
  window.scrollBy(0, 800);
}
</script>

<script>
  function scrollwin2(){
  document.getElementById("map").style.height = "100%";
}
</script>

 <style type="text/css">
     
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #from-link{

      	color: black;
      	font-weight: bold;
      }
       #to-link{
      	color: black;
      	font-weight: bold;
      }

      @media only screen and (max-width: 768px) {

          #map{
            zoom : 150%;
          }

      }
    </style>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="#">About Us</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="heatmap.php">Heatmap</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="map_1.php">Geofence</a>
    </li>
  
  </ul>
</nav>


	<div class="limiter" id="maindiv">
		<div class="container-login100" style="background-image: url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-1 p-b-30">
				<form class="login100-form validate-form" id="calculate-route" name="calculate-route" action="#" method="get">
					

					<span class="login100-form-title p-t-20 p-b-45">
						Safest Route 
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="from" id="from"  onfocus="this.value=''" placeholder="Source">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
						
					</div>
				  <a id="from-link" href="#">Get my position</a>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="text" name="to" id="to"  onfocus="this.value=''" placeholder="Destination">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
						
					</div>
					 <a id="to-link" href="#">Get my position</a>
<div class="radio">
<span></span>  <label><input type="radio" name="optradio" checked><h6><b> Day </b></h6></label></span>  


 <span><label><input type="radio" name="optradio"><h6><b> Night </b></h6></label></span> 
</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit" id="sub" onclick="scrollwin2();calculateRoute();scrollWin();" >
							Directions
						</button>
					
					</div>

				

				</form>
			</div>

		</div>
	</div>
	  <div id="map"></div>
    <p id="error"></p>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
 <script async defer 
  src= 
"https://maps.googleapis.com/maps/api/js?key=AIzaSyC7A7SxsYrrTJG8Aj3r-xMt1bGL00qJiLM&libraries=visualization"> 
  </script> 
</html>