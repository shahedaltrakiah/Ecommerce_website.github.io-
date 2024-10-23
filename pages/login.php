<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/loginstyle.css" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- Bootstrap CSS -->
    <!-- <link href="../css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Document</title>
  </head>
  
  <body onload="isGuest()">
    <div class="container" id="container">
      <div class="form-container sign-up-container overflow-auto">
        <form  class='mt-3'id="registerForm" action="../php/handler_register.php" method="POST" onsubmit="return registerUser(event)">
          <input class='m-3' type="text" id="userName" name="username" placeholder="Username" >
          <input  type="text" id="firstName" name="first_name" placeholder="First Name" >
          <input class='m-3' type="text" id="lastName" name="last_name" placeholder="Last Name" >
          <input  type="email" id="email" name="email" placeholder="Email" >
          <input class='m-3' type="tel" id="phone" name="phone_number" placeholder="Phone Number" >
          <input  type="password" id="password" name="password" placeholder="Password" >
          <input  class='m-3' type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" >
          <button type="submit">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
      <form action="../php/handler_login.php" method="POST" id="loginForm" onsubmit="return LoginUser(event)"  >
        <h1>Sign In</h1>
        <input type="email" name="email" placeholder="Email" id="loginEmail"  />
        <input class='m-3' type="password" name="password" placeholder="Password" id="loginPassword"  />
        <button id="loginSubmit" type="submit">Sign In</button>
      </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p>To keep connected with us please login with your personal info</p>
            <button class="ghost" id="signIn">Sign In</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello, Friend!</h1>
            <p>Enter your personal details and start with us</p>
            <button class="ghost" id="signUp">Sign Up</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      function registerUser(event) {
        event.preventDefault();
        try {
          const userName = document.getElementById("userName").value;
          const firstName = document.getElementById("firstName").value;
          const lastName = document.getElementById("lastName").value;
          const email = document.getElementById("email").value;
          const phone = document.getElementById("phone").value;
          const password = document.getElementById("password").value;
          const confirmPassword = document.getElementById("confirmPassword").value;

          if (!userName || !firstName || !lastName || !email || !phone || !password || !confirmPassword) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'All fields are required!',
              confirmButtonColor: '#3B5D50'
            });
            return false;
          }
          console.log("Form passed validation and is submitting");
          document.getElementById("registerForm").submit();
          return true;
          

        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred salem registration. Please try again.',
            confirmButtonColor: '#3B5D50'
          });
          console.error('Error during form submission:', error);
        }
      }



      // function LoginUser(event) {
      //   event.preventDefault();
      //   try {
       
      //     const email = document.getElementById("loginEmail").value;
      //     const password = document.getElementById("loginPassword").value;
        

      //     if ( !email ||  !password) {
      //       Swal.fire({
      //         icon: 'error',
      //         title: 'Error',
      //         text: 'All fields are required!',
      //         confirmButtonColor: '#3B5D50'
      //       });
      //       return false;
      //     }
      //     console.log("Form passed validation and is submitting");
      //     document.getElementById("loginForm").submit();
      //     return true;
          

      //   } catch (error) {
      //     Swal.fire({
      //       icon: 'error',
      //       title: 'Error',
      //       text: 'An error occurred salem registration. Please try again.',
      //       confirmButtonColor: '#3B5D50'
      //     });
      //     console.error('Error during form submission:', error);
      //   }
      // }
      function LoginUser(event) {
    event.preventDefault();  // Prevent the form from reloading the page

    try {
        const email = document.getElementById("loginEmail").value;
        const password = document.getElementById("loginPassword").value;

        // Basic validation
        if (!email || !password) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'All fields are required!',
                confirmButtonColor: '#3B5D50'
            });
            return false;
        }

        console.log("Form passed validation and is submitting");

        // Submit the form if all validation passes
        document.getElementById("loginForm").submit();
        return true;

    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred during login. Please try again.',
            confirmButtonColor: '#3B5D50'
        });
        console.error('Error during form submission:', error);
    }
}

    </script>
    <script src="../js/auth.js"></script>
  
 

 
   

    
    <script src="../js/main.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/tiny-slider.js"></script>
	<script src="../js/custom.js"></script>
  </body>
</html>
