<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "esolat";

$conn = new mysqli($host, $user, $pass, $db);

$result = $conn->query("SELECT * FROM info WHERE id = 1");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="logo.png" type="image/png">
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('sw.js');
    }
    </script>
    <title>Digital Signage</title>
    <style>
        :root {
            --primary-color: #6a097d;
            --bg-dark: #000;
            --text-white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            background: var(--bg-dark);
            color: var(--text-white);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        header {
            background: linear-gradient(to right, #4834d4, var(--primary-color), #4834d4);
            text-align: center;
            padding: 10px;
            border-bottom: 3px solid #f0932b;
            min-width: 100%;
            min-height: 10%;
        }
        header h1 { margin: 0; font-size: 2.5rem; letter-spacing: 2px; }
        header p { margin: 5px 0 0; font-size: 1rem; opacity: 0.8; }

        .middle-container {
            flex: 1;
            display: flex;
            padding: 10px;
            gap: 10px;
        }

        .slider-box {
            flex: 7;
            position: relative;
            background: #111;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #333;
            min-width: 75%;
            min-height: 80%
        }

        .slider-box img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: 1s;
        }

        .slide.active {
            opacity: 1;
        }

        .countdown-overlay {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255,255,255,0.9);
            color: black;
            padding: 5px 20px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .info-sidebar {
            flex: 3;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .date-clock-box {
            background: white;
            color: #333;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            min-height: 20%;
            min-width: 32%;
        }
        .clock { font-size: 5rem; font-weight: bold; color: #4834d4; }
        .date { font-size: 2rem; font-weight: 600; }

        .announcement-box {
            flex: 1;
            background: #111;
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f1c40f;
            flex-direction: column;
            min-height: 30%;
            min-width: 48%;
        }

        .announcement-box h2 { color: #f1c40f; margin-bottom: 10px; font-size: 1.5rem; }
        .announcement-box p { font-size: 1.2rem; line-height: 1.4; }

        .prayer-bar {
            background: var(--primary-color);
            display: flex;
            justify-content: space-around;
            padding: 10px;
            gap: 5px;
            min-width: 100%;
            min-height: 10%;
        }

        .prayer-card {
            background: rgba(255,255,255,0.1);
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .prayer-name { font-size: 2rem; text-transform: uppercase; margin-bottom: 5px; }
        .prayer-time { font-size: 3rem; font-weight: bold; }

        /* Style untuk Pop-up */
        .overlay-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9); /* Hitam pekat sedikit telus */
            display: none; /* Sembunyi secara default */
            z-index: 9999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            animation: fadeIn 0.5s;
        }

        .overlay-content h1 { font-size: 5rem; color: #f1c40f; margin: 0; }
        .overlay-content p { font-size: 3rem; margin: 10px 0; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div id="prayer-popup" class="overlay-popup">
        <div class="overlay-content">
            <h1 id="popup-title">MASUK WAKTU</h1>
            <p id="popup-sub">SOLAT ZOHOR</p>
            <div style="font-size: 1.5rem; margin-top: 20px;">Sila matikan telefon bimbit</div>
        </div>
    </div>
    <header>
        <h1><?php echo $data['nama']; ?></h1>
        <p><?php echo $data['lokasi']; ?></p>
    </header>

    <div class="middle-container">
        <div class="slider-box">
            <?php
                $dir = "poster/";
                $images = glob($dir . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
                
                foreach($images as $index => $image) {
                    $active = ($index == 0) ? "active" : "";
                    echo '<img src="'.$image.'" class="slide '.$active.'">';
                }
            ?>
        </div>

        <div class="info-sidebar">
            <div class="date-clock-box">
                <div class="date" id="live-date">--- | -- --- ----</div>
                <div class="clock" id="live-clock">--:--:--</div>
            </div>
            <div class="announcement-box" id="announcement-box">
                <h2 id="title">Memuatkan...</h2>
                <p id="content">Sila tunggu sebentar.</p>
            </div>
        </div>
    </div>

    <div class="prayer-bar">
        <div class="prayer-card">
            <div class="prayer-name">Subuh</div>
            <div class="prayer-time" id="subuh">--:--</div>
        </div>
        <div class="prayer-card">
            <div class="prayer-name">Syuruk</div>
            <div class="prayer-time" id="syuruk">--:--</div>
        </div>
        <div class="prayer-card"> 
            <div class="prayer-name">Zohor</div>
            <div class="prayer-time" id="zohor">--:--</div>
        </div>
        <div class="prayer-card">
            <div class="prayer-name">Asar</div>
            <div class="prayer-time" id="asar">--:--</div>
        </div>
        <div class="prayer-card">
            <div class="prayer-name">Maghrib</div>
            <div class="prayer-time" id="maghrib">--:--</div>
        </div>
        <div class="prayer-card">
            <div class="prayer-name">Isyak</div>
            <div class="prayer-time" id="isyak">--:--</div>
        </div>
    </div>

    <script>
        const iqamahSettings = {
            subuh: <?php echo $data['iq_subuh']; ?>,
            zohor: <?php echo $data['iq_zohor']; ?>,
            asar: <?php echo $data['iq_asar']; ?>,
            maghrib: <?php echo $data['iq_maghrib']; ?>,
            isyak: <?php echo $data['iq_isyak']; ?>
        };

        let waktuSolatData = {};

        function updateClock() {
            const now = new Date();
            const currentTime = now.toLocaleTimeString('en-GB', { hour12: false }).substring(0, 5);
            const seconds = now.getSeconds();
            
            document.getElementById('live-clock').innerText = now.toLocaleTimeString('en-GB');
            const data_date = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('live-date').innerText = now.toLocaleDateString('ms-MY', data_date).toUpperCase();

            const senaraiSolat = ['subuh', 'zohor', 'asar', 'maghrib', 'isyak'];

            senaraiSolat.forEach(waktu => {
                if (waktuSolatData[waktu]) {
                    let prayerTime = waktuSolatData[waktu].substring(0, 5);
                    
                    if (currentTime === prayerTime && seconds === 0) {
                        showPopup("MASUK WAKTU", "SOLAT " + waktu.toUpperCase(), 60);
                    }

                    let offset = iqamahSettings[waktu] || 10;
                    let iqamahTime = calculateIqamah(prayerTime, offset);

                    if (currentTime === iqamahTime && seconds === 0) {
                        showPopup("SOLAT BERJEMAAH", "AKAN BERMULA", 60);
                    }
                }
            });
        }

        function calculateIqamah(timeStr, offset) {
            let [hrs, mins] = timeStr.split(':').map(Number);
            let d = new Date();
            d.setHours(hrs);
            d.setMinutes(mins + offset);
            return d.toLocaleTimeString('en-GB', { hour12: false }).substring(0, 5);
        }

        function showPopup(title, sub, duration) {
            const popup = document.getElementById('prayer-popup');
            document.getElementById('popup-title').innerText = title;
            document.getElementById('popup-sub').innerText = sub;
            popup.style.display = 'flex';
            const audio = new Audio('beep.mp3');
            audio.play();
            setTimeout(() => { popup.style.display = 'none'; }, duration * 1000);
        }
        setInterval(updateClock, 1000);

        async function updateSolat() {
            try {
                const response = await fetch('data.php');
                const data = await response.json();
                waktuSolatData = data; 
                
                document.getElementById('subuh').innerText = data.subuh;
                document.getElementById('syuruk').innerText = data.syuruk;
                document.getElementById('zohor').innerText = data.zohor;
                document.getElementById('asar').innerText = data.asar;
                document.getElementById('maghrib').innerText = data.maghrib;
                document.getElementById('isyak').innerText = data.isyak;
            } catch (err) {
                console.log("Error :", err);
            }
        }
        setInterval(updateSolat, 1000);

        let current = 0;
        const slides = document.querySelectorAll('.slide');

        function nextSlide() {
            if(slides.length === 0) return;
            
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }

        if(slides.length > 1) {
            setInterval(nextSlide, 10000);
        }

        let announcements = [];
        let currentIndex = 0;

        async function loadAnnouncements() {
            const res = await fetch('announcement.php');
            announcements = await res.json();
            if(announcements.length > 0) {
                displayNext();
            }
        }

        function displayNext() {
            const box = document.getElementById('announcement-box');
            const title = document.getElementById('title');
            const content = document.getElementById('content');

            box.classList.add('fade-out');

            setTimeout(() => {
                title.innerText = announcements[currentIndex].tajuk;
                content.innerText = announcements[currentIndex].kandungan;
                
                box.classList.remove('fade-out');
                
                currentIndex = (currentIndex + 1) % announcements.length;
            }, 500);
        }

        setInterval(() => {
            if(announcements.length > 1) displayNext();
        }, 10000);

        loadAnnouncements();

        setTimeout(() => { location.reload(); }, 3600000);
    </script>
</body>
</html>