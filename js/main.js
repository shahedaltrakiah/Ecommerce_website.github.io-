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
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("fname").value = '';
                document.getElementById("lname").value = '';
                document.getElementById("email").value = '';
                document.getElementById("message").value = '';
            }
        });
        return true;
    }
}

document.getElementById("subscribeForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;

    if (name === "" || email === "") {
        // Show an error alert if fields are empty
        Swal.fire({
            title: 'Error!',
            text: 'Fields cannot be empty.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3B5D50'

        }).then((result) => {
            if (result.isConfirmed) {
                // Clear the fields if "OK" is clicked
                document.getElementById("name").value = '';
                document.getElementById("email").value = '';
            }
        });
    } else {
        // Show success message
        Swal.fire({
            title: 'Success!',
            text: 'You have subscribed successfully!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3B5D50'

        }).then((result) => {
            if (result.isConfirmed) {
                // Clear the fields after the success message
                document.getElementById("name").value = '';
                document.getElementById("email").value = '';
            }
        });
    }
});


// Set the date we're counting down to
const countdownDate = new Date("October 31, 2024 23:59:59").getTime();

// Update the countdown every second
const countdownFunction = setInterval(() => {
    // Get current date and time
    const now = new Date().getTime();

    // Find the distance between now and the countdown date
    const distance = countdownDate - now;

    // Calculate days, hours, minutes, and seconds
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the results in the respective HTML elements
    document.getElementById("days").innerHTML = days + " ";
    document.getElementById("hours").innerHTML = hours + " ";
    document.getElementById("minutes").innerHTML = minutes + " ";
    document.getElementById("seconds").innerHTML = seconds + " ";

    // If the countdown is over, display a message
    if (distance < 0) {
        clearInterval(countdownFunction);
        document.getElementById("timer").innerHTML = "EXPIRED";
    }
}, 1000);


