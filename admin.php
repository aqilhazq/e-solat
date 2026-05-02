<?php
include 'data.php'; // Pastikan fail sambungan DB anda betul

$target_dir = "poster/"; // Folder simpanan imej

// --- 1. PROSES UPLOAD FAIL (IMEJ ATAU CSV) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Jika ada fail Imej (Poster)
    if (isset($_FILES['image'])) {
        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Poster berjaya diupload! ";
        }
    }

    // Jika ada fail CSV (Jadual Waktu Solat)
    if (isset($_FILES['file_jadual'])) {
        $file = $_FILES['file_jadual']['tmp_name'];
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $tarikh = $data[0]; $subuh = $data[1]; $syuruk = $data[2];
                $zohor = $data[3]; $asar = $data[4]; $maghrib = $data[5]; $isyak = $data[6];

                //$sql = "INSERT INTO solat (tarikh, subuh, syuruk, zohor, asar, maghrib, isyak) VALUES ('$tarikh', '$subuh', '$syuruk', '$zohor', '$asar', '$maghrib', '$isyak')";
                //$conn->query($sql);
                $reg = $conn->prepare("INSERT INTO solat (tarikh, subuh, syuruk, zohor, asar, maghrib, isyak) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $reg->bind_param("sssssss", $tarikh, $subuh, $syuruk, $zohor, $asar, $maghrib, $isyak);
                $reg->execute();
            }
            fclose($handle);
            echo "Jadual SQL dikemaskini! ";
        }
    }

    // Kemaskini Data Teks (Nama Masjid/Iqamah) jika ada
    if (isset($_POST['nama'])) {
        $nama = $_POST['nama'];
        $sql = "UPDATE info SET nama = '$nama' WHERE id = 1";
        $conn->query($sql);
    }
}

// --- 2. PROSES PADAM FAIL ---
if (isset($_GET['delete'])) {
    $file_to_delete = $_GET['delete'];
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
        header("Location: admin.php");
    }
}

// Ambil senarai imej untuk dipaparkan
$images = glob($target_dir . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin System - SolatTV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; background: #eee; padding: 10px; }
        .section { background: white; padding: 15px; margin-bottom: 10px; border-radius: 8px; }
        img { width: 80px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>

<div class="section">
    <h3>Upload Baru</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Pilih Imej:</label><br>
        <input type="file" name="image"> <!-- Gunakan nama 'image' atau 'file_jadual' -->
        <button type="submit">Hantar</button>
    </form>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Pilih CSV:</label><br>
        <input type="file" name="file_jadual"> <!-- Gunakan nama 'image' atau 'file_jadual' -->
        <button type="submit">Hantar</button>
    </form>
</div>

<div class="section">
    <h3>Urus Poster (.jpg / .png)</h3>
    <table>
        <?php foreach($images as $image): ?>
        <tr>
            <td><img src="<?php echo $image; ?>"></td>
            <td><a href="?delete=<?php echo $image; ?>" style="color:red;">Padam</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<p><a href="index.php">Lihat Paparan Utama</a></p>

</body>
</html>