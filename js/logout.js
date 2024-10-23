function logout() {
    if (confirm("Are you sure you want to logout?")) {
        fetch('logout.php') 
            .then(response => {
                if (response.ok) {
                    window.location.reload(); 
                } else {
                    alert('Logout failed, please try again.'); 
                }
            })
            .catch(error => {
                console.error('Error during logout:', error);
                alert('An error occurred. Please try again.'); 
            });
    }
}
