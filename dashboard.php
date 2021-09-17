<?php

session_start();
include('connection.php');
$uservalue = $_SESSION['user'];
$getValue = $_GET['id2'];
$carValue=0;

if (isset($_POST['cancelBook'])) {
  $sql2 = "UPDATE register SET booking_car_id='0' WHERE (username='$uservalue' || email='$uservalue')";
  $sql4 = "SELECT * from register where (username='$uservalue' || email='$uservalue')";
  $result4 = $conn->query($sql4);
  while ($row4 = $result4->fetch_assoc()) {
    $idValue = $row4['booking_car_id'];
    $sql3 = "UPDATE addTaxi SET booked_state='0',source_pincode='0',destination_pincode='0' WHERE id=$idValue";
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    if ($result3 && $result2) {
      header('location:dashboard.php');
    } else {
      echo "<script> alert('can not perform')</script>";
    }
  }
}
if (isset($_POST['logout'])) {
  unset($_SESSION['user']);
  unset($_SESSION['activeuser']);
  unset($_SESSION['admin']);
  header('location:login.php');
}

if ($_SESSION['user']) {
  $sql = "SELECT * from register where (username='$uservalue' || email='$uservalue')";
  $result = $conn->query($sql);
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxi Booking| Dashboard</title>
    <link rel="stylesheet" href="build.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
  </head>

  <body>
    <header>
      <nav class="flex items-center justify-between flex-wrap bg-black px-24 py-2">
        <a href="welcome.php">
          <div class="flex items-center flex-shrink-0 text-white mr-6">
            <img src="./images/logo.svg" class="w-14 h-14 mr-2" alt="Taxi Logo">
            <span class="font-semibold text-xl tracking-tight">Book a Taxi</span>
          </div>
        </a>

        <div class="w-1/4 block ml-auto">
          <div class="text-lg flex justify-end">
            <a href="dashboard.php" class="block mt-4 mr-14 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
              Your Bookings
            </a>
            <form method="POST">
              <?php
              echo "<button style='color:white' class='logout' type='submit' name='logout' value='Logout'>Log Out</button>";
              ?>
            </form>
          </div>
        </div>
      </nav>
      <div class="bg-white shadow mx-auto py-6 px-24">
        <h1 class="text-3xl font-bold text-gray-900">
          Dashboard
        </h1>
      </div>
    </header>
    <main>
      <?php
      if ($result->num_rows > 0) {
        while ($row2 = $result->fetch_assoc()) {
          $idValue = $row2['booking_car_id'];
          if ($idValue > 0) {
            $sql2 = "SELECT * from addTaxi where id=$idValue";
            $result2 = $conn->query($sql2);
            while ($row = $result2->fetch_assoc()) {
              $pincodeSource=$row['source_pincode'];
              $pincodeDestination=$row['destination_pincode'];
      ?>
              <div class="flex flex-col">
                <div class="-my-2 overflow-x-hidden mt-6">
                  <div class="py-2 align-middle inline-block min-w-full px-24">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              driver name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              Taxi Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              booking status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              Passengers Capacity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              Luggage Capacity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              Taxi Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              In cab entertainment
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-md font-medium text-gray-500 uppercase tracking-wider">
                              Price
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                              <span class="sr-only">Edit</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                              <div class="flex">
                                <div>
                                  <div class="text-md font-medium my-1">
                                    <?php echo $row['driver_name']; ?>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                              <div class="text-md capitalize"><?php echo $row['taxi_name']; ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                              <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                              </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-md">
                              <?php echo $row['passengers']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-md">
                              <?php echo $row['luggage']; ?>
                            </td>
                            <td class="px-6 uppercase py-4 whitespace-nowrap text-md">
                              <?php echo $row['taxi_number']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                              <?php if ($row['in_cab_entertainment'] > 0) {
                              ?>
                                <span class="px-2 capitalize inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                  available
                                </span>
                              <?php
                              } else {
                              ?>
                                <span class="px-2 capitalize inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                  Not available
                                </span>
                              <?php
                              } ?>
                            </td>
                            <td id="priceValue" class="px-6 capitalize py-4 whitespace-nowrap text-md">
                            
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-md font-medium">
                              <form method="POST">
                                <button type="submit" name="cancelBook" method="POST" class="text-red-600 hover:text-red-900 capitalize">
                                  <a>cancel booking</a>
                                </button>
                              </form>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <?php 
               if ($idValue > 0) {
                   ?>
              <div class="mx-auto py-6 px-24">
                <h1 id="route" class="text-3xl font-bold text-gray-900 capitalize">
                  
                </h1>  
              <div class="w-full mt-4 mb-10" style="height: 900px;" id="map"></div>
              </div>
              <?php
               }
               ?>
      
   <!-- code extra    -------------------------------------------------->
      
      
      
      
   <script>

    
      let map;
      function initMap() {
///////////////////////////////////

     var slat;
     var slng;
     var dlat;
     var dlng;
     var slatValue;
     var slngValue;
     var dlatValue;
     var dlngValue;
     var dj;
    async function getvalues(){  
  
     
      async function getCoordinates(address){       
      const response=await fetch("https://maps.googleapis.com/maps/api/geocode/json?address="+address+'&key=AIzaSyC3nSH3nD_lgHPgXS6Ci5DYEpONbpK1j70')
      const data= await response.json();
      const latitude=data.results[0].geometry.location.lat;
      const longitude=data.results[0].geometry.location.lng;
      slat=latitude.toString();
      slng=longitude.toString();
  
  }
  async function getCoordinatesDest(address){       
      const response=await fetch("https://maps.googleapis.com/maps/api/geocode/json?address="+address+'&key=AIzaSyC3nSH3nD_lgHPgXS6Ci5DYEpONbpK1j70')
      const data= await response.json();
      const latitude=data.results[0].geometry.location.lat;
      const longitude=data.results[0].geometry.location.lng;
      dlat=latitude.toString();
      dlng=longitude.toString();
  
  }

    // let scor= getCoordinates('248001');
    await  getCoordinates(<?php echo "$pincodeSource"; ?>).then(() => {
       slatValue=slat;
       slngValue=slng;
     });
     await  getCoordinatesDest(<?php echo "$pincodeDestination"; ?>).then(() => {
       dlatValue=dlat;
       dlngValue=dlng;
     });

    
    }

    getvalues().then(()=>{
        const s1at=parseFloat(slatValue);
        const slng=parseFloat(slngValue);
        const d1at=parseFloat(dlatValue);
        const dlng=parseFloat(dlngValue);

        var start = new google.maps.LatLng(slat,slng);
        var end = new google.maps.LatLng(dlat,dlng);
        
        const cities = [
          {lat: s1at , lng:slng}, 
          {lat: d1at, lng:dlng}, 
       
        ];
        var option ={
          zoom: 7,
          center: start,
       
        };

        // Loop through cities, adding markers
        // for (let i=0; i<cities.length; i++) {
        //   let position = cities[i]; 
          
        //   let mk = new google.maps.Marker({position: position, map: map});
        // }

        map = new google.maps.Map(document.getElementById('map'),option);
        var display = new google.maps.DirectionsRenderer();
        var services = new google.maps.DirectionsService();
        display.setMap(map);
            var request ={
                origin : start,
                destination:end,
                travelMode: 'DRIVING'
            };
            services.route(request,function(result,status){
                if(status =='OK'){
                    display.setDirections(result);
                }
            });

       
        const service = new google.maps.DistanceMatrixService(); 
      const matrixOptions = {
        origins: [ `${s1at},${slng}`], 
        destinations: [` ${d1at}, ${dlng}`], 
        travelMode: 'DRIVING',
        unitSystem: google.maps.UnitSystem.IMPERIAL
      };
      
      service.getDistanceMatrix(matrixOptions, callback);

     
      function callback(response, status) {
        if (status !== "OK") {
          alert("Error with distance matrix");
          return;
        }
         console.log(response); 

        
        let routes = response.rows[0].elements;
          let leastseconds = 86400; 
          let drivetime = "";
          let closest = "";
         
          for (let i=0; i<routes.length; i++) {
            const routeseconds = routes[i].duration.value;
            if (routeseconds > 0 && routeseconds < leastseconds) {
              leastseconds = routeseconds;
              drivetime = routes[i].duration.text;
              distance = parseFloat(routes[i].distance.text)*1.6;
              console.log(distance); 
              console.log(drivetime);
              
              <?php 
             
              if($row['taxi_type']==='prime sedan'){
                $carValue=100;
              }
              if($row['taxi_type']==='Sedan'){
                $carValue=80;
              }
              if($row['taxi_type']==='micro'){
                $carValue=60;
              }
              if($row['taxi_type']==='mini'){
                $carValue=50;
              }
            ?>
              document.getElementById("priceValue").innerHTML=`Rs ${parseInt((distance*5)+ <?php echo $carValue ?>)}`;
              document.getElementById("route").innerHTML=`Your Route ( Duration: ${drivetime})`;
              closest = response.originAddresses[i]; 
            }
          }
        //   alert("The closest location is " + closest + " (" + drivetime + ")");
    }
    });
//////////////////////////////////   
      }
    </script>
      
      
      
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3nSH3nD_lgHPgXS6Ci5DYEpONbpK1j70&callback=initMap">
    </script>
    
   <!-- to here   ------------------------------------>
      <?php
            }
          } else {
            echo "<h1 style='text-align:center;font-size:2rem; margin-top:2rem;'>No bookings</h1>";
          }
        }
      } else {
        echo "<h1 style='text-align:center;font-size:2rem; margin-top:2rem;' >No bookings</h1>";
      }

      ?>
    </main>
    <!-- <script src="maps.js"></script> -->
  </body>

  </html>
<?php
}

?>