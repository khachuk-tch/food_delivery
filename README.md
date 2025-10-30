
# Local Food Delivery System (v1.0)

## Overview
A PHP + MySQL based local food delivery system. Includes user and admin panels.

## Installation
1. Upload files to server (public/ is web root).
2. Import database file: database/food_delivery.sql
3. Update DB constants in includes/config.php
4. Visit: http://your-domain-or-localhost/public/

## Default credentials
- Admin: khachuk@gmail.com/kha123
- User: waitai@gmail.com/wa123

## Support
Email: debbarma.khachuk111@gmail.com


 ## 🥡 Khachuk Food – Local Food Delivery System

**Khachuk Food** is a local food delivery web app built using **PHP, MySQL, AJAX, and Bootstrap**.  
It allows users to browse menus, place orders, and track their order status in real time.  
The admin panel helps restaurants manage menu items and track orders efficiently.

---

### 🚀 Features

- 🛒 Browse and order local food items  
- ⏱️ Real-time order status updates  
- 📦 Automatic “delivery time” comments (e.g. “Your food will arrive in 30–60 minutes”)  
- 👨‍🍳 Admin dashboard for menu & order management  
- 📱 Progressive Web App (PWA) – installable like a mobile app  
- 🌙 Modern responsive design using Bootstrap  

---

### 🧩 Technologies Used

| Component | Technology |
|------------|-------------|
| **Frontend** | HTML, CSS, JavaScript, AJAX, Bootstrap |
| **Backend** | PHP  |
| **Database** | MySQL |
| **Server** | Apache (XAMPP) |
| **PWA** | Manifest + Service Worker |

---

### ⚙️ Folder Structure

```
food_delivery/
│
├── admin/ All the admin file inside the folder
│   
-----user/ All users file inside the folder│   
│   
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── uploads/
│   │   └── icons/
│   ├── 
│   ├── index.php
│   └──.htaccess
│── service-worker.js
├── manifest.json
└── README.md
```

---

### 🛠️ Installation Steps

1. **Download or Clone the Repository**
   ```bash
   git clone https://github.com/khachuk-tch/khachuk-food.git
   ```

2. **Move Project to XAMPP’s `htdocs` Folder**
   ```
   C:\xampp\htdocs\food_delivery/
   ```

3. **Create Database**
   - Open **phpMyAdmin**
   - Create database: `food_delivery`
   - Import SQL file (if included)

4. **Update Database Credentials**
   - In `includes/config.php`, update:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'food_delivery');
     ```

5. **Run the Project**
   ```
   http://localhost/food_delivery/public/
   ```

---

### 📱 PWA Installation

1. Open the app in your browser.  
2. You’ll see a pop-up or install icon “**Install Khachuk Food**”.  
3. Click **Install** → The app will appear on your home screen like a native app.  

---

### 🧑‍💼 Admin Panel

- URL: `/food_delivery/public/admin_login  
- Manage:
  - Menu Items  
  - Orders  
  - Delivery Status  

---

### 📸 Screenshots

| Desktop | Mobile |
|----------|---------|
| ![Desktop View](public/screenshots/desktop-view.png) | ![Mobile View](public/screenshots/mobile-view.png) |

---

### 🧑‍💻 Developer

**Project by:** Tongthok World  
**Technologies:** PHP • MySQL • AJAX • Bootstrap • PWA  

---

### 📄 License

This project is open-source for learning and personal use.  
Feel free to modify or expand it for your own local delivery service.