// const emailField = document.getElementById("floatingEmail");
// const passwordField = document.getElementById("floatingPassword");
// const confirmPasswordField = document.getElementById("floatingConfirmPassword");
// const registerButton = document.getElementById("floatingRegister");
// const userNameField = document.getElementById("userName");
// const firstName = document.getElementById("firstName");
// const lastName = document.getElementById("lastName");
// const signUpButton = document.getElementById('signUp');
// const signInButton = document.getElementById('signIn');
// const container = document.getElementById('container');
// const loginEmail = document.getElementById("loginEmail");
// const loginPassword = document.getElementById("loginPassword");
// const loginSubmit = document.getElementById("loginSubmit");
// const phoneNumber = document.getElementById('phoneNumber');
// const phoneRegex = /^\d{7,}$/; 

// signUpButton.addUserListener('click', () => {
//     container.classList.add("right-panel-active");
// });

// signInButton.addUserListener('click', () => {
//     container.classList.remove("right-panel-active");
// });

// async function registerUser(user) {
//     user.preventDefault();
    
//     registerButton.disabled = true;
//     try{

//     if (!userNameField.value || !firstName.value || !lastName.value || !phoneNumber.value || !emailField.value || !passwordField.value || !confirmPasswordField.value) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'All fields are required!',
//             confirmButtonColor: '#3B5D50'
//         });
//         registerButton.disabled = false;  
//         return false;  
//     }

//     if (passwordField.value !== confirmPasswordField.value) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'Passwords do not match!',
//             confirmButtonColor: '#3B5D50'
//         });
//         registerButton.disabled = false;  
//         return false;  
//     }

//     const passwordRegex = /^(?=.*\d)(?=.*[A-Z]).{8,}$/;
//     if (!passwordRegex.test(passwordField.value)) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'Password must be at least 8 characters long and contain at least one number and one uppercase letter.',
//             confirmButtonColor: '#3B5D50'
//         });
//         registerButton.disabled = false;  
//         return false; 
//     }

//     if (!phoneRegex.test(phoneNumber.value)) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'Please enter a valid mobile number.',
//             confirmButtonColor: '#3B5D50'
//         });
//         registerButton.disabled = false;  
//         return false;
//     }
    
//     const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     if (!emailRegex.test(emailField.value)) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'Please enter a valid email address.',
//             confirmButtonColor: '#3B5D50'
//         });
//         registerButton.disabled = false;  
//         return false; 
//     }
    
//     fetch('../php/test_register.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === 'success') {
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Success',
//                 text: 'Registration successful!',
//                 confirmButtonColor: '#3B5D50'
//             }).then(() => {
//                 document.getElementById('registerForm').reset();
//                 window.location.reload();
//             });
//         } else {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: data.message || 'Registration failed. Please try again.',
//                 confirmButtonColor: '#3B5D50'
//             });
//         }
//     })
//     .catch(error => {
//         console.error('Error:', error);
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'This email is already registered.',
//             confirmButtonColor: '#3B5D50'
//         });
//     });

// } catch (error) {
//     console.error('Error:', error);
//     Swal.fire({
//         icon: 'error',
//         title: 'Error',
//         text: 'This email is already registered.',
//         confirmButtonColor: '#3B5D50'
//     });
// }

//     registerButton.disabled = false;
// }

// async function loginUser(user) {
//     user.preventDefault(); 

//     loginSubmit.disabled = true; 

//     try {
      
//         if (loginEmail.value === "" || loginPassword.value === "") {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: 'All fields are required!',
//                 confirmButtonColor: '#3B5D50'
//             });
//             loginSubmit.disabled = false;
//             return false;  
//         }

       
//         const formData = new FormData();
//         formData.append('email', loginEmail.value);
//         formData.append('password', loginPassword.value);

       
//         const response = await fetch('../php/test_register.php', {
//             method: 'POST',
//             body: formData
//         });

        
//         const data = await response.json();

        
//         if (data.status === 'success') {
//             Swal.fire({
//                 icon: 'success',
//                 title: 'Success',
//                 text: 'Registration successful!',
//                 confirmButtonColor: '#3B5D50'
//             }).then(() => {
//                 document.getElementById('registerForm').reset();
//                 window.location.reload();
//             });
//         } else {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: data.message || 'Registration failed. Please try again.',
//                 confirmButtonColor: '#3B5D50'
//             });
//         }
//     } catch (error) {
       
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: 'An unexpected error occurred. Please try again.',
//             confirmButtonColor: '#3B5D50'
//         });
//     } finally {
      
//         loginSubmit.disabled = false;
   
//         loginEmail.value = "";
//         loginPassword.value = "";
//     }
// }


// loginSubmit.addUserListener("click", loginUser);

// loginSubmit.addUserListener("click", loginUser);

