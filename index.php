<?php
session_start();
include('connection.php');
$insert_user = 0;
if (isset($_POST['login'])) {
    $active = $_SESSION['activeuser'];
    if ($active) {
        header('location:welcome.php');
    } else {
        header('location:login.php');
    }
}

if (isset($_POST['submit'])) {
    $userName = $_POST['username'];
    $eMail = strtolower($_POST['email']);
    $pass1 = $_POST['password'];
    $pass2 = $_POST['password2'];
    $fullName = $_POST['fullname'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $hash = password_hash($pass1, PASSWORD_BCRYPT);

    $sql = "SELECT username,email FROM register where username='$userName' or email='$eMail'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script> alert('Username or Email already exist')</script>";
    } else {
        if ($pass1 === $pass2) {
            $insert = "INSERT INTO register(username,fullname,email,passwordUser) values('$userName' ,'$fullName','$eMail','$hash')";
            $result = $conn->query($insert);
            if ($result) {
                $insert_user = 1;
            } else {
                echo "error in inserting";
            }
        } else {
            echo "<script> alert('Both Password Must Be Same')</script>";
        }
    }
    $conn->close();
}
?>


<!-- Html Code -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="build.css">
</head>

<body class="bg-gray-200 min-h-screen">
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
                    <a href="login.php" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-gray-200">
                        Login
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <div class="container w-2/3 flex justify-center items-center min-h-screen mx-auto">
        <div class="w-full">
            <div class="w-full flex">
                <div class="w-1/2 h-auto hidden lg:block bg-cover rounded-l-lg" style="background-image: url('https://images.unsplash.com/photo-1535337722-7eb07f382538?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=631&q=80')"></div>
                <div class="w-1/2 bg-white px-5 py-8 rounded-lg lg:rounded-l-none">
                    <h3 class="pt-4 text-2xl text-center font-bold">Create an Account!</h3>
                    <form class="px-8 pt-6 pb-8 bg-white rounded" method="POST">
                        <div class="mb-6">
                            <label class="capitalize block mb-2 text-lg font-bold text-gray-700" for="email">
                                username*
                            </label>
                            <input type="text" name="username" oninput="checkUsername()" class="w-full px-3 py-3 mb-3 text-lg leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" onkeypress="return (event.charCode > 64 && event.charCode < 91) 
                            || (event.charCode > 96 && event.charCode < 123) 
                            || (event.charCode >= 48 && event.charCode <= 57)" placeholder="Username" pattern="[A-Za-z]+[0-9]+" title="UserName must be your name followed by some number" minlength="5" maxlength="20" autocomplete="off" oninput="myFun()" id="username" required />
                            <p id="errortext" class="text-xs italic text-red-500 hidden">*UserName must be your name followed by some number, length should be greater than 5</p>
                        </div>

                        <div class="mb-6">
                            <label class="capitalize block mb-2 text-lg font-bold text-gray-700" for="email">
                                full name*
                            </label>
                            <input type="text" name="fullname" class="w-full px-3 py-3 mb-3 text-lg leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" onkeypress="return (event.charCode > 64 && event.charCode < 91) 
                            || (event.charCode > 96 && event.charCode < 123) 
                            || (event.charCode==32)" placeholder="Full Name" minlength="5" maxlength="30" autocomplete="off" required />
                        </div>

                        <div class="mb-6">
                            <label class="capitalize block mb-2 text-lg font-bold text-gray-700" for="email">
                                email*
                            </label>
                            <input class="w-full px-3 py-3 text-lg leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="email" type="email" name="email" oninput="checkEmail()" autocomplete="off" placeholder="Email" required />
                            <p id="errortextemail" class="text-xs italic text-red-500 hidden my-4">Email is invalid!</p>
                        </div>


                        <div class="mb-2 md:flex md:justify-between">
                            <div class="mb-4 md:mr-2 md:mb-0">
                                <label class="capitalize block mb-2 text-lg font-bold text-gray-700" for="password">
                                    password*
                                </label>
                                <input class="w-full px-3 py-3 mb-3 text-lg leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" type="password" name="password" placeholder="Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$" title="Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character:" oninput="checkPassword()" id="password" required />
                            </div>
                            <div class="md:ml-2">
                                <label class="capitalize block mb-2 text-lg font-bold text-gray-700" for="c_password">
                                    confirm password*
                                </label>
                                <input type="password" class="w-full px-3 py-3 mb-3 text-lg leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" name="password2" placeholder="Retype Password" title="Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character:" oninput="comparePassword()" id="confirmPassword" required />
                            </div>
                        </div>
                        <p id="errortext2" class="text-xs italic text-red-500 hidden my-4">*Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character</p>
                        <p id="errortext3" class="text-xs italic text-red-500 hidden my-4">Passwords didn't match!</p>
                        <div class="mb-6 text-center">
                            <button class="w-full px-4 py-3 text-lg font-bold text-white bg-yellow-400 rounded-full hover:bg-yellow-500 focus:outline-none focus:shadow-outline" type="submit" name="submit">
                                Register Account
                            </button>
                        </div>
                        <hr class="mb-6 border-t-2" />
                        <div class="text-center">
                            <a class="inline-block text-sm text-yellow-500 align-baseline hover:text-yellow-300" href="login.php">
                                Already have an account? Login!
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
</body>

</html>