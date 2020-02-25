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
<html lang="en">
<head>
	<title>Login V12</title>
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
            
                $query = "select latitude,longitude,content from `accounts`";
                if(count(fetchAll($query))>0){
                    foreach(fetchAll($query) as $row){
                      ?>
                   
					 <p class="lead text-muted"><?php   $GLOBALS['z'] = $row['latitude'];  $GLOBALS['y'] = $row['longitude'];  $GLOBALS['x'] = $row['content']; ?></p>
					
				     <?php
                    }
                }else{
                    echo "No Pending Requests.";
                }
            ?>
            
  <script>
var lati; 
	console.log(lati = <?php echo $z ?>);
var longi;
	console.log(longi = <?php echo $y ?>);
var con; 
	console.log(con = <?php echo $x ?>);

</script>


    <script>
    	  
  function calculateRoute(from, to) {
    // Center initialized to Naples, Italy
     var colors = ['#2AB1D6'];
    var myOptions = {
      zoom: 10,
      center: new google.maps.LatLng(28.644800,77.216721),
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


      var marker = new google.maps.Marker({ 
		position:  {lat: lati, lng: longi}, 
		map: mapObject
		}); 


var contentString ='<h5> <?php echo $x ?> </h5>'

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });


 marker.addListener('click', function() {
    infowindow.open(map, marker);
  });



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
  window.scrollBy(0, 600);
}
</script>


 <style type="text/css">
      #map { 
     
        height: 100%;
        margin-top: 10px;
      }
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
    </style>
</head>
<body>
	
	<div class="limiter" id="maindiv">
		<div class="container-login100" style="background-image: url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
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

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit" id="sub" onclick="calculateRoute();scrollWin();" >
							Directions
						</button>
					
					</div>

				

				</form>
			</div>

		</div>
	</div>
	
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