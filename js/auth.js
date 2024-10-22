document.addEventListener('DOMContentLoaded', function() {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const userName = document.getElementById("userName").value;
    const firstName = document.getElementById("firstName").value;
    const lastName = document.getElementById("lastName").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateRegisterForm()) {
            submitRegisterForm();
        }
    });

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (validateLoginForm()) {
            submitLoginForm();
        }
    });
});

function validateRegisterForm() {
   

    if (!userName || !firstName || !lastName || !email || !phone || !password || !confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'All fields are required!',
            confirmButtonColor: '#3B5D50'
        });
        return false;
    }

    if (userName.length < 4 || userName.length > 50) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Username must be between 4 and 50 characters.',
            confirmButtonColor: '#3B5D50'
        });
        return false;
    }
    if (firstName.length < 2) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'First name must be at least 2 characters long.',
          confirmButtonColor: '#3B5D50'
        });
        return false;
      }
      if (lastName.length < 2) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Last name must be at least 2 characters long.',
          confirmButtonColor: '#3B5D50'
        });
        return false;
      }
          if (!emailPattern.test(email)) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Please enter a valid email address.',
              confirmButtonColor: '#3B5D50'
            });
            return false;
          }
    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Passwords do not match!',
            confirmButtonColor: '#3B5D50'
        });
        return false;
    }

    document.getElementById("registerForm").submit();
    return true;
}

function validateLoginForm() {
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    if (!email || !password) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Email and password are required!',
            confirmButtonColor: '#3B5D50'
        });
        return false;
    }

    return true;
}

function submitRegisterForm() {
    const form = document.getElementById('registerForm');
    Swal.fire({
        icon: 'success',
        title: 'Signup Successful!',
        text: 'Your account has been created.',
        confirmButtonColor: '#3B5D50'
    }).then(function() {
        form.reset(); 
        window.location.reload(); 
    });

    
}

function submitLoginForm() {
    const form = document.getElementById('loginForm');
    Swal.fire({
        icon: 'success',
        title: 'Signup Successful!',
        text: 'Your account has been created.',
        confirmButtonColor: '#3B5D50'
    }).then(function() {
        form.reset();
        window.location.href = '../index.php';  
    });
}













