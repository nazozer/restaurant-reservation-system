<?php
// Veritabanı bağlantı bilgileri
$host = 'localhost';
$dbname = 'restoran';
$username = 'root';
$password = 'xxx'; // XAMPP'ta genelde şifre boş olur

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Formdan veri geldiyse işle
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Form verilerini al
    $name = $_POST["name"];
    $email = $_POST["email"];
    $datetime = $_POST["datetime"];
    $num_people = $_POST["num_people"];
    $special_request = $_POST["special_request"];

    // SQL sorgusu (güvenli: PDO + prepare)
    $sql = "INSERT INTO reservations (name, email, datetime, people_count, special_request)
            VALUES (:name, :email, :datetime, :people_count, :special_request)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':datetime', $datetime);
    $stmt->bindParam(':people_count', $num_people);
    $stmt->bindParam(':special_request', $special_request);

    // Veriyi kaydet ve sonucu bildir
    if ($stmt->execute()) {
        echo "Reservation saved successfully!";
    } else {
        echo "An error occurred, please try again.";
    }
}
?>
