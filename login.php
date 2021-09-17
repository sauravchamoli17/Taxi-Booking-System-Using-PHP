<!-- php code -->

<?php
session_start();
include('connection.php');
$errorShow = 0;
$checkSubmit = 0;
$pageshow = $_SESSION['activeuser'];

if ($pageshow) {
  header('location:welcome.php');
}

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signin'])) {
  header('location:register.php');
}

if (isset($_POST['submit'])) {
  $userNameEmail = strtolower($_POST['usernamemail']);
  $pass = $_POST['password'];
  $checkSubmit = 1;
  if ($checkSubmit > 0) {
    $_SESSION['user'] = $userNameEmail;
  }

  $sql = "SELECT * from register where (username='$userNameEmail' || email='$userNameEmail')";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $data = $result->fetch_array();

    if (password_verify($pass, $data['passwordUser']) && $data['username'] == "Admin123") {
      $_SESSION['admin'] = $data['username'];
      header('location:welcome.php');
    } else if (password_verify($pass, $data['passwordUser'])) {
      header('location:welcome.php');
    } else {
      $errorShow = 1;
    }
  } else {
    $errorShow = 1;
  }
  $conn->close();
}





?>

<!-- HTML code -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="build.css">
</head>

<body class="bg-gray-200 min-h-screen">
  <header>
    <nav class="flex items-center flex-wrap bg-black px-24 py-2">
      <a href="welcome.php">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
          <img src="./images/logo.svg" class="w-14 h-14 mr-2" alt="Taxi Logo">
          <span class="font-semibold text-xl tracking-tight">Book a Taxi</span>
        </div>
      </a>
    </nav>
  </header>
  <div class="container w-1/3 flex justify-center items-center min-h-screen mx-auto">
    <div class="w-full">
      <div class="w-full flex">
        <div class="w-full bg-white px-5 py-16 rounded-lg lg:rounded-l-none">
          <h3 class="text-3xl text-center font-bold">Welcome Back!</h3>
          <form method="POST" class="px-8 pt-6 bg-white rounded">

            <div class="mb-4">
              <label class="capitalize block mb-2 text-xl font-bold text-gray-700" for="email">
                email or username*
              </label>
              <input <?php if ($errorShow > 0) {
                        echo 'style="border:1px solid red;"';
                      } ?> class="w-full px-3 py-3 mb-3 text-xl leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="text" name="usernamemail" placeholder="Username or Email" autocomplete="off" minlength="5" maxlength="50" required />
            </div>

            <div class="mb-4">
              <label class="capitalize block mb-2 text-xl font-bold text-gray-700" for="email">
                password*
              </label>
              <input <?php if ($errorShow > 0) {
                        echo 'style="border:1px solid red;"';
                      } ?> class="w-full px-3 py-3 mb-3 text-xl leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="password" name="password" placeholder="Password" required />
            </div>
            <div class="mb-4">
              <?php
              if ($errorShow > 0) {
                echo "<p style='color:red;text-align:center;'>Invalid Authentications Credentials!</p>";
              }
              ?>
            </div>

            <div class="text-center mb-8">
              <button class="w-full px-4 py-3 text-lg font-bold text-white bg-yellow-400 rounded-full hover:bg-yellow-500 focus:outline-none focus:shadow-outline" type="submit" name="submit">
                Login
              </button>
            </div>
            <hr class="mb-6 border-t-2" />
            <div class="text-center">
              <a class="inline-block text-xl text-yellow-500 align-baseline hover:text-yellow-300" href="index.php">
                Don't have an account? Sign Up!
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>


<?php if ($errorShow > 0) {
  echo 'style="border:2px solid red;"';
} ?>