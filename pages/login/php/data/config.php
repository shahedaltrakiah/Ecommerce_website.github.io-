<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
    $tableCheckQuery = "SHOW TABLES LIKE 'Customers'";
    $stmt = $conn->query($tableCheckQuery);

    
    if ($stmt->rowCount() == 0) {
        $createTableQuery = "CREATE TABLE Customers(
            customer_id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone_number VARCHAR(20),
            image_url VARCHAR(255),
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
           )";

        $conn->exec($createTableQuery);
        echo "Table 'Customer' created successfully<br>";
    } else {
        echo "Table 'Customer' already exists<br>";
    }

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
