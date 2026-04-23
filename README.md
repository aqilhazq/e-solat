# e-Solat: Digital Signage System

**e-Solat** is a web-based digital signage solution designed to display automated prayer times, real-time clocks, and Islamic educational content. It is specifically optimized for large-screen displays in suraus and mosques to keep the congregation informed.

---

## 🚀 Key Features

* **Real-time Prayer Times:** Automatically displays the daily schedule for Subuh, Syuruk, Zohor, Asar, Maghrib, and Isyak.
* **Dynamic Digital Clock:** A prominent live clock showing the current date (Gregorian) and time.
* **Educational Snippets:** A dedicated section for "Akhlak" or Hadith of the day to provide spiritual reminders (e.g., HR. Tirmidzi).
* **Custom Branding:** Integrated header and banner for specific institutions (e.g., Surau Al-Mustaqim, MRSM Tun Abdul Razak).
* **High Visibility UI:** A high-contrast dark theme with purple accents, designed for readability from a distance.

---

## 🛠️ Technical Stack

Based on the development environment, the project utilizes:

| Component      | Technology                                     |
| :------------- | :--------------------------------------------- |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla or jQuery)    |
| **Backend** | PHP (Server-side logic)                        |
| **Database** | MySQL (Stores prayer schedules and quotes)     |
| **Environment**| XAMPP / WAMP (Localhost deployment)            |

---

## 📂 System Architecture

The project is structured to run as a local web application:
- `index.php`: The primary dashboard interface.
- `/assets`: Contains images (like the Quran background) and icons.
- `/css`: Custom styling for the "Digital Signage" look.
- `/js`: Handles the real-time clock updates and dynamic content transitions.
- `/config`: Database connection and API settings for prayer time fetching.

---

## ⚙️ Installation & Setup

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/aqilhazq/e-solat.git
    ```
2.  **Web Server Setup:**
    * Move the project folder to your local server directory (e.g., `C:/xampp/htdocs/e-solat/`).
    * Ensure Apache and MySQL services are running.
3.  **Database Configuration:**
    * Import the provided SQL schema via `phpMyAdmin`.
    * Update connection details in the configuration file if necessary.
4.  **Accessing the App:**
    * Open your browser and navigate to `http://localhost/e-solat/`.
    * For signage use, press `F11` to enter Fullscreen mode.

---

## 🖥️ Dashboard Layout

1.  **Top Bar:** Institution Name & Location.
2.  **Central Left:** Main Brand Identity (e.g., "Surau Al-Mustaqim").
3.  **Top Right:** Current Date & Large Digital Time Display.
4.  **Middle Right:** "Akhlak" / Daily Quote Box.
5.  **Bottom Bar:** 6-column grid displaying the chronological prayer times.

---

## 📜 License
This project is developed for community and educational use at MRSM Tun Abdul Razak.

---
*Documentation generated for e-Solat Project v1.0*
