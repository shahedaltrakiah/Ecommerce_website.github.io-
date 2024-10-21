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

function validateSubscribeForm() {
    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();

    if (name === "" || email === "") {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'All fields are required!',
            confirmButtonColor: '#3B5D50'
        });
        return false; // Prevent form submission
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Message sent!',
            text: 'We will get back to you soon.',
            confirmButtonColor: '#3B5D50'
        });
        return true; // Allow form submission
    }
}

// Set the date we're counting down to (replace with your desired date)
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

document.getElementById("toggle-button").addEventListener("click", function() {
    const extraCards = document.querySelectorAll(".extra-card");
    const button = this;

    // Check if the extra cards are currently displayed or hidden
    if (extraCards[0].style.display === "none" || extraCards[0].style.display === "") {
        extraCards.forEach(card => {
            card.style.display = "block"; // Show the extra cards
        });
        button.textContent = "Show Less"; // Change button text
    } else {
        extraCards.forEach(card => {
            card.style.display = "none"; // Hide the extra cards
        });
        button.textContent = "Show More"; // Change button text
    }
});
