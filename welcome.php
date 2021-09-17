<?php
session_start();
include('connection.php');

$user = $_SESSION['user'];
$_SESSION['activeuser'] = $user;
if ($user) {
  $sql = "SELECT * from register where (username='$user' || email='$user')";
  $booked_id = 0;
  $result = $conn->query($sql);
  $sql2 = "select * from addTaxi";
  $result2 = $conn->query($sql2);
}

if (isset($_POST['logout'])) {
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
  <link rel="stylesheet" href="build.css" type="text/css">
  <title>Taxi Booking | Home</title>
</head>

<body>
  <?php
  if ($result->num_rows > 0) {
    while ($row3 = $result->fetch_assoc()) {
      $booked_id = $row3['booking_car_id'];
    }

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
          <?php
          if ($_SESSION['admin']) {
          ?>
            <div class="text-lg flex justify-between">
              <a href="addtaxi.php" class="block mt-4 lg:inline-block active:text-gray-200 lg:mt-0 text-white hover:text-gray-200">
                Add Taxi
              </a>
              <a href="dashboard.php" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
                Your Bookings
              </a>

              <form method="POST">
                <?php
                echo "<button style='color:white' class='logout hover:text-gray-200' type='submit' name='logout' value='Logout'>Log Out</button>";

                ?>
              </form>
            <?php
          } else {
            ?>
              <div class="text-lg flex justify-end">
                <a href="dashboard.php" class="block mt-4 mx-10 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
                  Your Bookings
                </a>

                <form method="POST">
                  <?php
                  echo "<button style='color:white' class='logout ml-10' type='submit' name='logout' value='Logout'>Log Out</button>";
                  ?>
                </form>
              <?php
            }
              ?>

              </div>
            </div>
      </nav>
    </header>

    <div class="grid grid-cols-4 gap-12 py-12 px-24 mx-auto">
      <?php
      if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
          $bookedValue = $row['booked_state'];
      ?>
          <a class="container w-full bg-white rounded-xl shadow-lg cursor-pointer hover:scale-105 hover:shadow-2xl transform transition-all duration-500" <?php if ($bookedValue < 1 && $booked_id < 1) { ?> href="confirmation.php?id= <?php echo $row['id'];
                                                                                                                                                                                                                                        ?>" <?php
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                            ?>>

            <div>
              <img class="h-72 w-full object-contain" src="<?php echo $row['taxi_image']; ?>" alt="">
              <div class="px-4 pt-4 pb-2">

                <h1 class="text-2xl pb-2 font-bold text-gray-800 cursor-pointer capitalize"><?php echo $row['taxi_name']; ?></h1>
                <div class="flex flex-wrap ">
                  <span class="flex items-center rounded-full bg-yellow-500 uppercase text-white px-4 py-1 m-2 text-xs font-bold"><?php echo $row['taxi_type']; ?></span>
                  <?php if ($row['in_cab_entertainment'] > 0) {
                  ?>
                    <span class="flex items-center rounded-full bg-indigo-500 uppercase text-white px-4 py-1 m-2 text-xs font-bold"> In Cab Entertainment</span>

                  <?php } ?>
                  <span class="flex items-center rounded-full   <?php if ($row['booked_state'] > 0) {
                                                                  echo "bg-red-500";
                                                                } else {
                                                                  echo "bg-green-500";
                                                                } ?> uppercase text-white px-4 py-1 m-2 text-xs font-bold">
                    <?php if ($row['booked_state'] > 0) {
                      echo "Booked";
                    } else {
                      echo "Book Now";
                    } ?></span>

                  <span class="flex items-center rounded-full bg-blue-300 uppercase text-white px-4 py-1 m-2 text-xs font-bold"><?php echo $row['fuel_type']; ?></span>
                </div>
                <div class="py-1">
                  <h2 class="capitalize text-gray-600 text-xl py-1">Driver name: <span class="text-black"><?php echo $row['driver_name']; ?></span></h2>
                  <h2 class="capitalize text-gray-600 text-xl py-1">Passenger capacity : <span class="text-black"><?php echo $row['passengers']; ?></span></h2>
                  <h2 class="capitalize text-gray-600 text-xl py-1">Luggage capacity: <span class="text-black"><?php echo $row['luggage']; ?></span></h2>
                </div>
              </div>
            </div>
        <?php
        }
      }
        ?>
    </div>
    </a>
  <?php
  } else {
    header('location:login.php');
  }
  $conn->close();
  ?>

</body>

</html>