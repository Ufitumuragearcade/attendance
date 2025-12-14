#  Student Attendance Management System

A modern, responsive web-based attendance management system built with PHP, MySQL, and Bootstrap 5. This system allows educational institutions to efficiently track and manage student attendance records.

##  Features

### Dashboard

* **Real-time Statistics**: View total students, present/absent counts, and total records
* **Today's Attendance Rate**: Visual progress bar showing attendance percentage
* **Quick Actions**: Fast access to mark attendance, view records, and manage students
* **Recent Activity**: Display of the last 5 attendance records
* **Personalized Welcome**: Greets user with their name and current date

###  Student Management

* **Add Students**: Register new students with registration number, full name, and department
* **Edit Students**: Update student information easily
* **Delete Students**: Remove students with confirmation prompt
* **View All Students**: Beautiful card-based layout with student details
* **Empty State Handling**: Helpful prompts when no students exist

###  Attendance Tracking

* **Mark Attendance**: Interactive present/absent selection with visual feedback
* **View Records**: Comprehensive table view of all attendance records
* **Statistics Display**: Count of total, present, and absent records
* **Date & Time Stamps**: Automatic recording of attendance date and time
* **Color-coded Status**: Easy-to-read badges for present (green) and absent (red)

###  Authentication

* **Secure Login**: User authentication system
* **Session Management**: Secure session handling
* **Logout Functionality**: Safe logout with session destruction

###  UI/UX Features

* **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
* **Modern Interface**: Clean, professional design with Bootstrap 5
* **Gradient Themes**: Beautiful color gradients throughout the application
* **Hover Animations**: Smooth transitions and interactive elements
* **Icon Integration**: Bootstrap Icons for enhanced visual communication
* **Alert Messages**: User-friendly success and error notifications
* **Empty States**: Helpful messages when data is not available

##  Technologies Used

* **Backend**: PHP 7.4+
* **Database**: MySQL
* **Frontend**: HTML5, CSS3, JavaScript
* **Framework**: Bootstrap 5.3
* **Icons**: Bootstrap Icons 1.10
* **Database Driver**: PDO (PHP Data Objects)

##  Prerequisites

Before you begin, ensure you have the following installed:

* PHP 7.4 or higher
* MySQL 5.7 or higher
* Apache/Nginx web server (XAMPP, WAMP, or LAMP recommended)
* Web browser (Chrome, Firefox, Safari, or Edge)

## 🔧 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Ufitumuragearcade/attendance-system.git
cd attendance-system
```

### 2. Database Setup

Create a new MySQL database:

```sql
create database attendance_system;
```

Import the database schema:

```sql
use attendance_system;

create table users (
    id int auto_increment primary key,
    fullname varchar(100) not null,
    email varchar(100) unique not null,
    password varchar(255) not null,
    created_at timestamp default current_timestamp
);

create table students (
    id int auto_increment primary key,
    reg_no varchar(50) unique not null,
    fullname varchar(100) not null,
    department varchar(100),
    created_at timestamp default current_timestamp
);

create table attendance (
    id int auto_increment primary key,
    student_id int not null,
    status enum('Present', 'Absent') not null,
    date datetime not null,
    foreign key (student_id) references students(id) on delete cascade
);
```

Insert a default user (for testing):

```sql
insert into users (fullname, email, password)
values ('Admin User', 'admin@test.com', '1234');
```

### 3. Configure Database Connection

Edit `config/db.php` with your database credentials:

```php
<?php
$host = 'localhost';
$db   = 'attendance_system';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
```

### 4. Start the Server

**Using XAMPP/WAMP**

* Copy the project folder to `htdocs` or `www`
* Start Apache and MySQL
* Open `http://localhost/attendance-system`

**Using PHP built-in server**

```bash
php -S localhost:8000
```

### 5. Login

Default credentials:

* **Email**: [admin@test.com](mailto:admin@test.com)
* **Password**: 1234

##  Project Structure

```
attendance-system/
├── auth/
│   ├── login.php
│   └── logout.php
├── config/
│   └── db.php
├── students/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── delete.php
├── attendance/
│   ├── mark.php
│   └── view.php
├── dashboard.php
└── README.md
```

##  Usage

### Adding Students

1. Go to Dashboard
2. Click **Manage Students**
3. Click **Add New Student**
4. Fill in details
5. Submit the form

### Marking Attendance

1. Go to Dashboard
2. Click **Mark Attendance**
3. Select student
4. Choose status
5. Submit

### Viewing Records

1. Click **View Records**
2. Review attendance table

##  Security Considerations

>  This project is for learning purposes. For production:

* Use `password_hash()` and `password_verify()`
* Add CSRF protection
* Validate inputs server-side
* Enforce HTTPS
* Improve session security

##  Customization

Change gradients in CSS:

```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

##  Troubleshooting

* **DB Error**: Check MySQL service and credentials
* **Page Not Found**: Verify file paths
* **Session Issues**: Ensure `session_start()` is called

## 📸 Screenshots

Add screenshots in the `screenshots/` folder:

* dashboard.png
* mark-attendance.png
* students.png

##  Contributing

1. Fork the repo
2. Create a feature branch
3. Commit changes
4. Push and open a PR

##  License

MIT License

## Author

**Ufitumurage Arcade**

* GitHub: [https://github.com/Ufitumuragearcade](https://github.com/Ufitumuragearcade)
* Email: itarcade9@gmail.com

---

⭐ If you find this project useful, give it a star!
