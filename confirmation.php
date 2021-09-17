<?php
session_start();
include('connection.php');

$getValue = $_GET['id'];
$user = $_SESSION['user'];
$error_check = 0;

if (isset($_POST['logout'])) {
  unset($_SESSION['user']);
  unset($_SESSION['activeuser']);
  unset($_SESSION['admin']);
  header('location:login.php');
}


if (isset($_POST['confirmSubmit'])) {
  $source_pincode = $_POST['source-pincode'];
  $destination_pincode = $_POST['destination-pincode'];
  if ($source_pincode === $destination_pincode) {
    $error_check = 1;
  } else {
    $sql2 = "UPDATE register SET booking_car_id='$getValue' WHERE (username='$user' || email='$user')";
    $sql3 = "UPDATE addTaxi SET booked_state='1',source_pincode='$source_pincode',destination_pincode='$destination_pincode' WHERE id=$getValue";
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    if ($result2 && $result3) {
      header("location:dashboard.php?id2=$getValue");
    } else {
      "<script> alert('error')</script>";
    }
  }
}

if ($_SESSION['user']) {
  $taxiId = $_GET['id'];
  $sql = "SELECT * from addTaxi where id=$taxiId";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Taxi Booking | Confirm Your Booking</title>
        <link rel="stylesheet" href="build.css">
        <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
      </head>
      <style>
        body {
          background: url('./images/pattern.svg') no-repeat;
          background-size: contain;
          background-color: #FCD34E;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
      </style>

      <body class="min-h-screen">
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
                <a href="dashboard.php" class="block mt-4 mx-6 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
                  Your Bookings
                </a>
                <form method="POST">
                  <?php
                  echo "<button style='color:white' class='logout mx-6' type='submit' name='logout' value='Logout'>Log Out</button>";

                  ?>
                </form>
              </div>
            </div>
          </nav>
        </header>
        <div class="min-h-screen flex items-center justify-center">
          <div class="container w-1/4 bg-white rounded-xl shadow-lg cursor-pointer hover:shadow-2xl transform transition-all duration-500">
            <img class="rounded-t-xl h-72 w-full object-cover" src="<?php echo $row['taxi_image']; ?>" alt="">
            <div class="px-4 pt-4 pb-6">
              <h1 class="text-2xl pb-2 text-center font-bold text-gray-800 cursor-pointer capitalize"><?php echo $row['taxi_name']; ?></h1>
              <div class="flex flex-wrap justify-between">
                <span class="flex items-center rounded-full bg-yellow-500 uppercase text-white px-4 py-1 my-2 text-xs font-bold"><?php echo $row['taxi_type']; ?></span>
                <?php if ($row['in_cab_entertainment'] > 0) {
                ?>
                  <span class="flex items-center rounded-full bg-indigo-500 uppercase text-white px-4 py-1 my-2 text-xs font-bold">in cab entertainment</span>
                <?php
                } ?>
                <span class="flex items-center rounded-full bg-red-500 uppercase text-white px-4 py-1 my-2 text-xs font-bold"><?php if ($row['booked_state'] > 0) {
                                                                                                                                echo "Booked";
                                                                                                                              } else {
                                                                                                                                echo "Book Now";
                                                                                                                              } ?></span>
                <span class="flex items-center rounded-full bg-blue-300 uppercase text-white px-4 py-1 my-2 text-xs font-bold"><?php echo $row['fuel_type']; ?></span>
              </div>
              <div class="py-1">
                <h2 class="capitalize text-center text-gray-600 text-xl py-1">driver name: <span class="text-black"><?php echo $row['driver_name']; ?></span></h2>
                <h2 class="capitalize text-center text-gray-600 text-xl py-1">passenger capacity: <span class="text-black"><?php echo $row['passengers']; ?></span></h2>
                <h2 class="capitalize text-center text-gray-600 text-xl py-1">luggage capacity: <span class="text-black"><?php echo $row['luggage']; ?></span></h2>
              </div>
              <form method="POST" id="booking-form">
                <div class="flex justify-around py-4">
                  <input type="number" min="100000" max="999999" oninput="checkPincode()" name="source-pincode" autocomplete="off" maxlength="6" class="focus:outline-none px-3 py-3 mx-2 w-2/4 focus:border-yellow-400 border border-gray-400 appearance-none rounded" id="source-pin" placeholder="Source Pincode" required>
                  <input type="number" min="100000" max="999999" oninput="checkPincode()" name="destination-pincode" autocomplete="off" maxlength="6" class="focus:outline-none px-3 mx-2 py-3 w-2/4 focus:border-yellow-400 border border-gray-400 appearance-none rounded" id="destination-pin" placeholder="Destination Pincode" required>
                </div>
                <p id="errortext" class="text-xs italic hidden text-red-500 pt-2 pb-2 pl-2">Source Pincode should be of 6 digits!</p>
                <?php
                if ($error_check > 0) {
                ?>
                  <p class="text-xs italic text-red-500 pt-2 pb-2 pl-2">Source and Destination can't be same!</p>
                <?php
                }
                ?>
                <button type="submit" name="confirmSubmit" class="bg-yellow-400 font-bold w-full hover:bg-yellow-300 focus:outline-none rounded-md px-6 py-3 mx-auto block text-white transition duration-500 ease-in-out mt-3 text-lg text-center no-underline">
                  Confirm Booking
                </button>
              </form>
              <a href="welcome.php" class="font-bold w-full focus:outline-none rounded-md px-6 py-1 mx-auto block text-gray-500 transition duration-500 ease-in-out mt-3 text-lg text-center no-underline hover:text-red-500">Cancel Order</a>
            </div>
          </div>
        </div>
        <script src="./script.js"></script>
      </body>

      </html>

<?php
    }
  }
} else {
  header('location:login.php');
}
?>