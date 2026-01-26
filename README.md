# PHP Task Manager Application

A role-based **Task Management System** built using **Core PHP (OOP)** and **MySQL**, designed to manage users and tasks securely with authentication, authorization, and CSRF protection.

This project demonstrates real-world backend concepts commonly expected from **junior PHP developers**.

---

## 🚀 Features

### 🔐 Authentication & Security
- User authentication (Login / Logout)
- Password hashing
- CSRF token protection
- Protected routes
- Forced logout on session expiry

### 👥 Role-Based Access Control
- **Admin**
  - Create, update, and delete users
  - Create, update, delete, and assign tasks
  - View all users and tasks
  - View user status (Active / Inactive)
- **User**
  - View tasks assigned to them
  - Update task status
  - Manage own profile
  - Change password

### 📝 Task Management
- Create, update, delete tasks
- Assign tasks to users
- Task status management (Pending/ Completed)
- AJAX-based task deletion (no page reload)

### 📊 User Status Tracking
- Shows whether a user is **active (logged in)** or **inactive (logged out)**

---

## 🛠️ Tech Stack

- **PHP** (OOP)
- **MySQL**
- **HTML5**
- **CSS3**
- **JavaScript**
- **AJAX**
- **Prepared Statements** (SQL Injection protection)
- **Bootstrap**


