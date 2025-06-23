# MINSU-Student-Kiosk

A Web-Based Student Information System for Mindoro State University (MINSU) IT Faculty.

---

## 📚 About the Project

**MINSU-Student-Kiosk** is a faculty-accessible system designed to search, retrieve, and manage student information.

The system runs in two separate modes:

### ✅ Kiosk Mode (Read-Only for Faculty & Staff)

* Search for students using name, course, or other attributes (excluding student ID).
* View student details without edit privileges.
* Publicly accessible on **faculty kiosks**.

### ✅ Admin Dashboard (Full Management Panel)

* Admins log in with credentials to manage student data.
* Full **Create, Read, Update, Delete (CRUD)** functionality.
* Accessible only via secured devices (non-kiosk access).

---

## 🛠️ Tech Stack

* **Backend Framework:** Laravel 11
* **Frontend:** Blade Templates with TailwindCSS
* **Database:** MySQL
* **Authentication:** Laravel Breeze (Admin Access)

---

## 🚀 Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/yourusername/MINSU-Student-Kiosk.git
cd MINSU-Student-Kiosk
```

### 2️⃣ Install Backend Dependencies

```bash
composer install
```

### 3️⃣ Install Frontend Dependencies

> **Note:** After cloning, always run `npm install` first to ensure you have all Node dependencies.

```bash
npm install
```

### 4️⃣ Configure Environment Variables

Rename `.env.example` to `.env` and update your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minsu_kiosk
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 5️⃣ Run Database Migrations

```bash
php artisan migrate
```

### 6️⃣ Install TailwindCSS (if not already installed)

```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

Update `tailwind.config.js` to scan Blade files:

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

Add Tailwind directives in `resources/css/app.css`:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 7️⃣ Start the Application

```bash
php artisan serve
```

Access the system at:

```
http://127.0.0.1:8000/
```

---

## 📷 Screenshots
![image](https://github.com/user-attachments/assets/d766aadd-5d90-4da3-b394-a0f28380911a)
![image](https://github.com/user-attachments/assets/0e80a861-c29f-41e7-bef7-dce56e60163d)
![image](https://github.com/user-attachments/assets/3a422b09-8ab7-4665-844b-33e37c1950df)
![image](https://github.com/user-attachments/assets/8203110a-6a3c-46ea-9a45-730c134423fe)![image](https://github.com/user-attachments/assets/60585c53-90b5-4a8c-bc19-ca04e0a05090)



---

## 👥 Contributors

* **Mark Lua** - Lead Developer
* **Wilfred** - Project Initiator

---

## 🔒 Editing Permissions

> Any authorized DID team members have permission to edit this file and modify system configurations.

---

## 📓 License

This project is licensed under the MIT License.

<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>
