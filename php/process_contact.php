<?php
include '../includes/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare and execute the query
        $query = "INSERT INTO contact_form (first_name, last_name, email, message) VALUES (:first_name, :last_name, :email, :message)";
        
        // Prepare statement
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $_POST['first_name']);
        $stmt->bindParam(':last_name', $_POST['last_name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':message', $_POST['message']);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'We will get back to you soon.',
                    confirmButtonColor: '#3B5D50' 
                }).then(function() {
                    window.location = '../pages/contact.php'; // Redirect back to contact page
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonColor: '#3B5D50' 
                });
            </script>";
        }

    } catch (PDOException $e) {
        // Handle any errors
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error',
                text: 'There was an issue connecting to the database.',
                confirmButtonColor: '#3B5D50' 
            });
            </script>";
    }
}
?>
