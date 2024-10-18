<!-- <?php
session_start();
include 'core/sessions.php';
$signInErrors = sessionGet('signInErrors');
$hasSignInErrors = !empty($signInErrors);
$signUpErrors = sessionGet('signUpErrors');
$hasSignUpErrors = !empty($signUpErrors);
$hasErrors = $hasSignUpErrors || $hasSignInErrors;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style/style.css" />
    <script src="./assets/js/auth/guest.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body onload="isGuest()">
<div class="container <?= $hasErrors ? 'right-panel-active' : '' ?>" id="container"> 
        <div class="form-container sign-up-container overflow-auto">
            <div class="my-5">
                <form action="handlers/handler_register.php" method="POST">
                    <?php foreach($signUpErrors as $error): ?>
                        <div class="alert alert-danger p-1"><?php echo $error; ?></div>
                    <?php endforeach ?>
                    
                    <input type="text" id="userName" name="name" placeholder="Name"  />
                    <input type="email" class='m-3' id="email" name="email" placeholder="Email" />
                    <input type="tel" id="phone" name="phone" placeholder="07 XXXXXXXX"  />
                    <input type="password" class='m-3' id="password" name="password" placeholder="Password" />
                    <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" />
                    <button type="submit" class='m-3' id="register">Sign Up</button>
                </form>
            </div>
        </div>

        <div class="form-container sign-in-container">
            <form action="handlers/handler_login.php" method="POST">
                <h1>Sign in</h1>
                
                <?php foreach($signInErrors as $error): ?>
                    <div class="alert alert-danger p-1"><?php echo $error; ?></div>
                <?php endforeach ?>

                <input type="email" name="email" placeholder="Email" id="loginEmail"  />
                <input type="password" class='m-3' name="password" placeholder="Password" id="loginPassword"  />
                <button type="submit" id="loginSubmit">Sign In</button>
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

    <script src="../js/auth.js"></script>
</body>
</html> -->
