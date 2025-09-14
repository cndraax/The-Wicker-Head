<?php
// Konfigurasi koneksi
$host = "localhost";
$user = "root";
$pass = "";
$db   = "thewickerhead";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama  = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['pesan']);

    $sql = "INSERT INTO contacts (nama, email, pesan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $nama, $email, $pesan);
        if ($stmt->execute()) {
            $message = "<div class='alert success'><i class='fa fa-check-circle'></i> Terima kasih <strong>$nama</strong>, pesanmu sudah terkirim!</div>";
        } else {
            $message = "<div class='alert error'><i class='fa fa-times-circle'></i> Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert error'><i class='fa fa-exclamation-circle'></i> Error SQL: " . $conn->error . "</div>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Contact Result</title>
  <link rel="stylesheet" href="contact.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>📩 Status Pengiriman Pesan</h1>
      <?php echo $message; ?>
      <a class="btn" href="index.html">⬅️ Kembali ke Beranda</a>
    </div>
  </div>
</body>
</html>
