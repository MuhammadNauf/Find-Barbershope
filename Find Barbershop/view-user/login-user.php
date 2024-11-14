<?php
include '../koneksi.php';

// Check if the connection is successful
$koneksi = new Koneksi();
$conn = $koneksi->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        // Validate and sanitize input
        $name = trim($_POST['name']);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $latitude = filter_var(trim($_POST['latitude']), FILTER_VALIDATE_FLOAT);
        $longitude = filter_var(trim($_POST['longitude']), FILTER_VALIDATE_FLOAT);

        // Check if latitude and longitude are valid
        if ($latitude === false || $longitude === false) {
            echo "Invalid latitude or longitude.";
            exit();
        }

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO user_barbershop (name, email, latitude, longitude) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssdd", $name, $email, $latitude, $longitude);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: home-user.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Find Barbershop</title>
    <link rel="stylesheet" href="../style/login-user.css">
    <script src="../js/login-user.js"></script>
</head>
<body class="body" onload="getLocation();">
<form action="" method="POST" class="myForm"> 
        <h2>Login</h2>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Name" required>
        
        <label for="email">Email</label>
        <input type="text" name="email" id="email" placeholder="Email" required>
        
        <input type="hidden" name="latitude" placeholder="Latitude" required readonly>
        <input type="hidden" name="longitude" placeholder="Longitude" required readonly>
        
        <button type="submit" name="add_user">Login</button>
    </form>
    
    <script type="text/javascript">
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.querySelector('.myForm input[name="latitude"]').value = position.coords.latitude;
            document.querySelector('.myForm input[name="longitude"]').value = position.coords.longitude;
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User has denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>
</body>
</html>