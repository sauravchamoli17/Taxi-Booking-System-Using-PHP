const pincodes = require('./data.js');

function checkUsername() {
  const usernameValue = document.getElementById("username").value;
  const re = "[A-Za-z]+[0-9]+";
  if (!usernameValue.match(re)) {
    document.getElementById("errortext").style.display = "block";
  } else {
    document.getElementById("errortext").style.display = "none";
  }
}

function checkPassword() {
  const password = document.getElementById("password").value;
  const re2 = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})";
  if (!password.match(re2)) {
    document.getElementById("errortext2").style.display = "block";
  } else {
    document.getElementById("errortext2").style.display = "none";
  }
}

function comparePassword(){
  const password  = document.getElementById('password').value;
  const confirmPassword  = document.getElementById('confirmPassword').value;
  if(password !== confirmPassword){
    document.getElementById('errortext3').style.display = "block";
  } else{
    document.getElementById('errortext3').style.display = "none";
  }
}

function checkEmail(){
  const emailVal = document.getElementById('email').value;
  const errorTextEmail = document.getElementById('errortextemail');
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if(!emailVal.match(re)){
    errorTextEmail.style.display = "block";
  } else{
    errorTextEmail.style.display = "none";
  }                                             
}

function checkPincode(){
  const sourcePinVal = document.getElementById('source-pin').value.trim();
  const destinationPinVal = document.getElementById('destination-pin').value.trim();
    if(sourcePinVal.length < 6 ){
      document.getElementById('errortext').innerHTML='Source Pincode should be of 6 digits!';
      document.getElementById('errortext').style.display='block';
    } 
    else if(sourcePinVal.length > 6){
      document.getElementById('errortext').innerHTML="Source Pincode can't be more than 6 digits!";
      document.getElementById('errortext').style.display='block';
    }  
    else if(destinationPinVal.length < 6 ){
       document.getElementById('errortext').innerHTML='Destination Pincode should be of 6 digits!';
       document.getElementById('errortext').style.display='block';
    }
    else if(destinationPinVal.length > 6){
      document.getElementById('errortext').innerHTML="Destination Pincode can't be more than 6 digits!";
      document.getElementById('errortext').style.display='block';
    }
    else{
      document.getElementById('errortext').style.display='none';
    }
}