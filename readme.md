# 🏥 Cura System: Hospital Management System

A full-featured, responsive web application built using PHP, MySQL, HTML/CSS, and JavaScript. The Cura System is designed to streamline hospital operations by offering secure login systems, role-based access control, appointment scheduling, and patient/doctor management features with a clean, user-friendly interface.

---

## 📋 Table of Contents

- [Features](#features)  
- [Tech Stack](#tech-stack)  
- [Directory Structure](#directory-structure)  
- [Prerequisites](#prerequisites)  
- [Installation & Setup](#installation--setup)  
- [Usage](#usage)  
- [Screenshots](#screenshots)  
- [Contributing](#contributing)  
- [License](#license)  
- [Contact](#contact)  

---

## 🚀 Features

- Role-Based Authentication (Admin, Doctor, Patient)  
- Secure Login with Password Encryption  
- Patient and Staff Record Management (CRUD)  
- Doctor Specialization and Timing Info  
- Appointment Booking with Date-Time Slot Checking  
- Admin Dashboard for System Overview  
- Responsive Design with HTML/CSS  
- MySQL-Based Persistent Storage  
- Printable Reports and Record Filtering  

---

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6)  
- **Backend**: PHP 7+  
- **Database**: MySQL  
- **Version Control**: Git & GitHub  

---

## 📂 Directory Structure

```
Hospital-Management-System-Cura_System/
├── assets/                   # Images, icons, CSS
├── hms/                      # Core application code
│   ├── admin/                # Admin panel pages
│   ├── doctor/               # Doctor dashboard
│   ├── patient/              # Patient dashboard
│   └── includes/             # Common includes like db config
├── Database External/        # SQL file for DB setup
├── Contact.html              # Static contact page
├── index.php                 # Landing page
├── style.css                 # Global stylesheet
└── README.md                 # Project documentation
```

---

## ⚙️ Prerequisites

- PHP 7.2 or higher  
- MySQL 5.7+ or MariaDB  
- Apache or Nginx Web Server  
- Git (optional for cloning)  

---

## 💾 Installation & Setup

1. **Clone the Repository**
   ```
   git clone https://github.com/Muhamad-Ahmed/Hospital-Management-System-Cura_System-.git
   cd Hospital-Management-System-Cura_System-
   ```

2. **Database Setup**  
   - Create a MySQL database (e.g., `cura_hms`)  
   - Import the SQL file from `Database External/` using phpMyAdmin or MySQL CLI:
     ```
     mysql -u username -p cura_hms < "Database External/schema_and_data.sql"
     ```

3. **Configure the Database Connection**  
   - Edit `hms/includes/db_config.php` and set:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'cura_hms');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     ```

4. **Run the Project**  
   - Move the project to your server's root directory (e.g., `htdocs` for XAMPP)  
   - Visit `http://localhost/Hospital-Management-System-Cura_System-/`
   

---

## 🚦 Usage

- **Admin Login**  
  - Manages doctors, patients, and appointments  

- **Doctor Login**  
  - Views schedule and patient details  

- **Patient Login**  
  - Books appointments and checks history  

---

## 🖼️ Screenshots

![Landing Page](/project%20screenshots/dashboard.png)  
![Chatbot](/project%20screenshots/chatbot.png)  
![Database](/project%20screenshots/database.png)  
![Login Page](/project%20screenshots/login%20page.png)
![Admin Dashboard](/project%20screenshots/admin%20dashboard.png)
![Appointment Booking](/project%20screenshots/appointment_booking.png)

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repo  
2. Create a new branch (`git checkout -b feature-name`)  
3. Commit your changes (`git commit -m "Add feature"`)  
4. Push to the branch (`git push origin feature-name`)  
5. Open a Pull Request  

---

## 📝 License

This project is licensed under the MIT License.  
You are free to use, modify, and distribute this software with proper attribution.

---

## ✉️ Contact

**Muhamad Ahmed**  
GitHub: [@Muhamad-Ahmed](https://github.com/Muhamad-Ahmed)  
LinkedIn: [linkedin.com/in/muhamad-ahmed](https://www.linkedin.com/in/ahmed-shahidd/)  
Email: ahmedshahid20222@gmail.com
