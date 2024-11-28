<?php
include 'db_config.php'; // Koneksi ke database

$response = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $name = isset($_POST['Full_Name']) ? $_POST['Full_Name'] : '';
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $phone = isset($_POST['Phone']) ? $_POST['Phone'] : '';
    $subject = isset($_POST['Subject']) ? $_POST['Subject'] : '';
    $message = isset($_POST['Message']) ? $_POST['Message'] : '';

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = "Alamat email tidak valid!";
    } else if (!empty($name) && !empty($email) && !empty($message)) {
        // Menggunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO contacts (full_name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            // Kirim email ke pemilik situs
            $to = "azizahf188@gmail.com"; // Email Anda
            $headers = "From: $email";
            $fullMessage = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";

            if (mail($to, $subject, $fullMessage, $headers)) {
                $response = "Pesan Anda berhasil dikirim!";
            } else {
                $response = "Pesan tersimpan, tetapi gagal mengirim email.";
            }
        } else {
            $response = "Terjadi kesalahan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response = "Semua field harus diisi!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Azizah Fitri Wibowo</title>
</head>

<body>
    <!-- Header Section -->
    <header>
        <a href="#home" class="logo">Azizah Fitri Wibowo</a>
        <div class='bx bx-menu' id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="home.html">Home</a></li>s
            <li><a href="about.html">About</a></li>
            <li><a href="portofolio.html">Portofolio</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="top-btn">
            <a href="#contact" class="nav-btn">Contact Me</a>
        </div>
    </header>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h2 class="heading">Contact <span>Me</span></h2>
        <form action="contact.php" method="POST">
            <div class="input-box">
                <input type="text" name="Full_Name" placeholder="Your Name" required>
                <input type="email" name="Email" placeholder="Your Email" required>
            </div>
            <div class="input-box">
                <input type="text" name="Phone" placeholder="Your Phone">
                <input type="text" name="Subject" placeholder="Subject" required>
            </div>
            <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
            <input type="submit" value="Send Message" class="btn">
        </form>

        <!-- Menampilkan Respons -->
        <?php if (!empty($response)): ?>
            <p class="response-message"><?php echo htmlspecialchars($response); ?></p>
        <?php endif; ?>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="social">
            <a href="https://www.linkedin.com/inamianus-christopher-sa
                osir-554972147/"><i class='bx bxl-linkedin'></i></a>
            <a href="https://github.com/"><i class='bx bxl-github'></i></a>
            <a href="https://https://x.com/zizah_hirofumi/"><i class='bx bxl-x'></i></a>
            <a href="https://www.instagram.com/zizah.ftri/"><i class='bx bxl-instagram'></i></a>
        </div>
        <p class="copyright">
            &copy; Zizah@2024
        </p>
    </footer>

    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="script.js"></script>
</body>

</html>