<?php

session_start();

include ('connection.php');

if(isset($_POST['submit'])){
  
    $taxiName=$_POST['taxiName'];
    $driverName=$_POST['driverName'];
    $taxiNumber=strtoupper($_POST['taxiNumber']);                                                                            
    $taxiType=$_POST['taxi_type'];
    $passengers=$_POST['passengers'];
    $luggage=$_POST['luggage'];
    $in_cab_entertainment=$_POST['cab_entertainment'];
    $fuelType=$_POST['fuel'];
    $bookedState=$_POST[''];

    // image upload 

    $image_name=$_FILES['file-upload']['name'];
    $image_name=preg_replace("/\s+/","_",$image_name);
    $image_tmpname=$_FILES['file-upload']['tmp_name'];
    $image_size=$_FILES['file-upload']['size'];
    $image_type=$_FILES['file-upload']['type'];
    $image_extension=pathinfo($image_name,PATHINFO_EXTENSION);
    $image_name=pathinfo($image_name,PATHINFO_FILENAME);
    $image_name=$image_name."_".date("mjyhis").".".$image_extension;
                                                                                               
    if(!empty($image_name)){
        if($image_size<=10000000){
            if($image_extension=="jpg" || $image_extension=="jpeg" || $image_extension=="png"){
                $final_file="image_store/".$image_name;
                $uploaded=move_uploaded_file($image_tmpname,$final_file);
                if($uploaded){
                    $insert="INSERT INTO addTaxi(taxi_name,driver_name,taxi_number,taxi_type,passengers,luggage,taxi_image,in_cab_entertainment,fuel_type) 
                    values('$taxiName','$driverName','$taxiNumber','$taxiType','$passengers','$luggage','$final_file','$in_cab_entertainment','$fuelType')";
                     $result = $conn->query($insert);
                     if($result){
                         echo '<script>alert("Insersion Successfull")</script>';
                     }
                     else{
                         echo '<script>alert("Error in Inserting")</script>';
                     }
                }
                else{
                    echo '<script>alert("Not Uploaded!")</script>';
                }
            }
            else{
                echo '<script>alert("insert png,jpg or jpeg images only")</script>';
            }
        }
        else{
            echo '<script>alert("File Size greater than given")</script>';
        }
    }
    else{
        echo '<script>alert("File name is empty")</script>';

    }



}
if(isset($_POST['logout'])){
  unset($_SESSION['user']);
  unset($_SESSION['activeuser']);
  unset($_SESSION['admin']);
  header('location:login.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Taxi</title>
    <link rel="stylesheet" href="build.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>
<?php
       if ($_SESSION['admin']){
           ?>
    <header>
      
        <nav class="flex items-center justify-between flex-wrap bg-black px-24 py-2">
            <a href="welcome.php">
              <div class="flex items-center flex-shrink-0 text-white mr-6">
                <img src="./images/logo.svg" class="w-14 h-14 mr-2" alt="Taxi Logo">
                <span class="font-semibold text-xl tracking-tight">Book a Taxi</span>
              </div>
            </a>
            
            <div class="w-1/4 block ml-auto">
              <div class="text-lg flex justify-between">
                <a href="addtaxi.php" class="block mt-4 lg:inline-block active:text-gray-200 lg:mt-0 text-white hover:text-gray-200">
                  Add Taxi
                </a>
                <a href="dashboard.php" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
                  Your Bookings
                </a>
                
                <form method="POST">
            <?php echo "<button style='color:white' class='logout' type='submit' name='logout' value='Logout'>Log Out</button>";
            ?>
                </form>
              </div>
            </div>
          </nav>
    </header>
    <div>
        <div class="md:grid md:grid-cols-3 md:gap-6 px-24 py-8">
          <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
              <h3 class="text-xl font-medium leading-6 text-gray-900">Add Taxi Profile</h3>
              <p class="mt-1 text-md text-gray-600">
                This information will be displayed publicly so be careful what you share.
              </p>
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <form method="POST" enctype="multipart/form-data">
              <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="taxiName" class="block capitalize text-xl font-medium text-gray-700">
                        taxi name
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <input autocomplete="off" 
                        name="taxiName"
                        maxlength="60" 
                        class="shadow appearance-none border rounded text-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="taxi_name" 
                        type="text" 
                        placeholder="Maruti Suzuki Alto" 
                        required>
                      </div>
                    </div>
                  </div>
                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="driverName" class="block capitalize text-xl font-medium text-gray-700">
                        Driver Name
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <input autocomplete="off" 
                        name="driverName"
                        maxlength="60" 
                        class="shadow appearance-none border rounded text-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="driver_name" 
                        type="text" 
                        placeholder="Type Name Here*" 
                        required>
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="company-website" class="block capitalize text-xl font-medium text-gray-700">
                        taxi number
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <input autocomplete="off" 
                        maxlength="10"
                        name="taxiNumber" 
                        class="shadow appearance-none border rounded text-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="taxi_number" 
                        type="text" 
                        placeholder="UK07AB1234" 
                        required>
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="taxi_type" class="block capitalize text-xl font-medium text-gray-700">
                        taxi type
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <select id="taxi_type" name="taxi_type" autocomplete="country" class="cursor-pointer mt-1 capitalize block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none text-xl" required>
                          <option class="capitalize text-xl" value="mini">mini</option>
                          <option class="capitalize text-xl" value="micro">micro</option>
                          <option class="capitalize text-xl" value="Sedan">sedan</option>
                          <option class="capitalize text-xl" value="prime sedan">prime sedan</option>
                        </select> 
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="passengers" class="block capitalize text-xl font-medium text-gray-700">
                        passengers capacity
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <select id="passengers" name="passengers" autocomplete="off" class="cursor-pointer mt-1 capitalize block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none text-xl">
                          <option class="capitalize text-xl" value="1">1</option>
                          <option class="capitalize text-xl" value="2">2</option>
                          <option class="capitalize text-xl" value="3">3</option>
                          <option class="capitalize text-xl" value="4">4</option>
                          <option class="capitalize text-xl" value="4">5</option>
                          <option class="capitalize text-xl" value="4">6</option>
                          <option class="capitalize text-xl" value="4">7</option>
                          <option class="capitalize text-xl" value="4">8</option>
                        </select> 
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="luggage" class="block capitalize text-xl font-medium text-gray-700">
                        luggage capacity
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <select id="luggage" name="luggage" autocomplete="off" class="cursor-pointer mt-1 capitalize block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none text-xl" required>
                          <option class="capitalize text-xl" value="1">1</option>
                          <option class="capitalize text-xl" value="2">2</option>
                          <option class="capitalize text-xl" value="3">3</option>
                          <option class="capitalize text-xl" value="4">4</option>
                        </select> 
                      </div>
                    </div>
                  </div>
      
                  <div>
                    <label for="taxi_photo" class="block text-xl capitalize font-medium text-gray-700">
                      taxi photo
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                      <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                          <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="file-upload" type="file" class="sr-only" required>
                          </label>
                          <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                          PNG, JPG, GIF up to 10MB
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="mt-4">
                    <span class="text-gray-700 capitalize text-xl">in cab entertainment</span>
                    <div class="mt-2">
                      <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="cab_entertainment" value="1" required>
                        <span class="ml-2 capitalize text-xl cursor-pointer">true</span>
                      </label>
                      <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="cab_entertainment" value="0" required>
                        <span class="ml-2 capitalize text-xl cursor-pointer">false</span>
                      </label>
                    </div>
                  </div>

                  <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                      <label for="fuel" class="block capitalize text-xl font-medium text-gray-700">
                        fuel type
                      </label>
                      <div class="mt-1 flex rounded-md shadow-sm">
                        <select id="fuel" name="fuel" autocomplete="off" class="cursor-pointer mt-1 capitalize block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none text-xl" required>
                          <option class="capitalize text-xl" value="petrol">petrol</option>
                          <option class="capitalize text-xl" value="diesel">diesel</option>
                          <option class="capitalize text-xl" value="cng">CNG</option>
                          <option class="capitalize text-xl" value="electric">electric</option>
                        </select> 
                      </div>
                    </div>
                  </div>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                  <button type="submit" 
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                  name="submit">
                    Save
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
       }
       else{
         header('location:login.php');
       }
      ?>
</body>
</html>