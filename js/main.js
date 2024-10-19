function validateForm() {
    var firstName = document.getElementById("fname").value;
    var lastName = document.getElementById("lname").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;

    if (firstName === "" || lastName === "" || email === "" || message === "") {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'All fields are required!',
            confirmButtonColor: '#3B5D50' 
        });
        return false; 
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Message sent!',
            text: 'We will get back to you soon.',
            confirmButtonColor: '#3B5D50' 
        });
        return true; 
    }
}