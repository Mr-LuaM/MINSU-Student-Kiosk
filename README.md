MINSU-Student-Kiosk

A Web-Based Student Information System for the Mindoro State University (MINSU) IT Faculty

---

## 📖 About the Project

MINSU-Student-Kiosk is a faculty-accessible system designed to quickly search, retrieve, and manage student information.
The system will be deployed as both a **kiosk for searching** and a **secured admin panel for full management**.

---

## 🏗️ System Structure

✅ **Kiosk Mode (Read-Only for Faculty & Staff)**

- Search for students using name, course, or other attributes (except student ID).
- View student details but with no editing privileges.
- Publicly accessible on **faculty kiosks**.

✅ **Admin Dashboard (Full CRUD with Authentication)**

- **Admins log in** to manage student data.
- Can **Create, Update, and Delete** student records.
- Accessible only via **secured PCs** (not on kiosks).

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Frontend:** TailwindCSS + Blade Templates
- **Database:** MySQL
- **Authentication:** Laravel Breeze (for admin login)

---

## 🚀 Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/yourusername/MINSU-Student-Kiosk.git
cd MINSU-Student-Kiosk
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install
```

### 3️⃣ Configure Environment Variables

Rename `.env.example` to `.env` and update database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minsu_kiosk
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 4️⃣ Run Database Migrations

```bash
php artisan migrate
```

### 5️⃣ Install TailwindCSS

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

Update `tailwind.config.js`:

```js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
```

Include Tailwind in `resources/css/app.css`:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 6️⃣ Generate Authentication (For Admin Panel)

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm run dev
```

### 7️⃣ Run the Server

```bash
php artisan serve
```

Access the system at:

```
http://localhost:8000
```

---

## 📷 Screenshots

_(Add UI screenshots later)_

---

## ✅ To-Do List

- [ ] Implement Student Search (Kiosk Mode)
- [ ] Design UI using TailwindCSS
- [ ] Set Up Backend & Database (MySQL)
- [ ] Implement Authentication & Admin Dashboard
- [ ] Deploy System

---

## 👥 Contributors

- **Mark Lua** - Lead Developer
- **Wilfred** - Project Initiator

---

## 📜 License

This project is licensed under MIT License.`<p align="center"><a href="https://laravel.com" target="_blank">``<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>``</p>`
