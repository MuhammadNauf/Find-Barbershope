<?php
session_start();
include '../koneksi.php';

$koneksi = new Koneksi();
$conn = $koneksi->getConnection();

if ($conn === null) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT name, latitude, longitude FROM find_barbershop";
$result = mysqli_query($conn, $query);

$barbershops = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $barbershops[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Builder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #f9fafb, #eaeef3);
            margin: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 50px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .navbar img {
            height: 30px;
        }
        .navbar ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 15px;
        }
        .navbar ul li a {
            text-decoration: none;
            color: #333;
        }
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 50px;
        }
        .hero-text {
            max-width: 50%;
        }
        .hero-text h1 {
            font-size: 36px;
            color: #2b2b6f;
        }
        .hero-text p {
            color: #555;
            margin: 20px 0;
        }
        .hero-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #map {
            height: 500px;
            width: 100%;
            margin-top: 50px;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #f5f5f5;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
    <div class="navbar">
        <img src="https://via.placeholder.com/100x30" alt="Logo">
        <ul>
            <!-- href="" isi dengan file yang mau di tuju bila tidak perlu di hapus aja -->
            <li><a href="#">Ubah Sesuaikan saja</a></li>
            <li><a href="#">Ubah Sesuaikan saja</a></li>
            <li><a href="#">Ubah Sesuaikan saja</a></li> 
            <li><a href="#">Ubah Sesuaikan saja</a></li>
            <li><a href="#">Ubah Sesuaikan saja</a></li>
            <li><a href="#">Ubah Sesuaikan saja</a></li>
        </ul>
    </div>

    <div class="hero">
        <div class="hero-text">
            <h1>Buat Web Sendiri dengan Website Builder</h1>
            <p>Bikin website atau toko online sendiri cuma dalam hitungan menit. Tanpa perlu tahu coding. Serba mudah dan cepat dengan Zyro website builder.</p>
        </div>
        <div class="hero-image">
            <img src="../img/pangkas.jpg" alt="Website Builder">
        </div>
    </div>

    <div id="map"></div>

    <script type="text/javascript">
        // Initialize the map
        var map = L.map('map').setView([0.5104, 101.4470], 13);
        
        // Load and display OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var barbershops = <?php echo json_encode($barbershops); ?>;

        barbershops.forEach(function(barbershop) {
            var position = [parseFloat(barbershop.latitude), parseFloat(barbershop.longitude)];
            var marker = L.marker(position).addTo(map)
                .bindPopup(`<h4>${barbershop.name}</h4>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${barbershop.latitude},${barbershop.longitude}" target="_blank">Get Directions</a>`);
        });
    </script>

    <footer>
        <p>&copy; 2024 Find Barbershop | Bagus Tyogo</p>
    </footer>
</body>
</html>