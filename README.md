#  Capstone4 MVC Application

A full-featured PHP MVC application with authentication system, database integration, and dynamic routing.

##  Project Overview

This is a complete PHP MVC framework implementation for the capstone project, featuring:

###  Features Implemented (Chapter 4)
-  **MVC Architecture** with proper separation of concerns
-  **Dynamic Routing System** with GET/POST support
-  **MySQL Database Integration** using PDO
-  **User Authentication System** with sessions
-  **User Registration & Login/Logout**
-  **Protected Routes** with middleware-like functionality
-  **Clean & Responsive UI** with CSS styling

##  Technologies Used

- **PHP 8.2+** - Server-side programming
- **MySQL** - Database management
- **PDO** - Database abstraction layer
- **HTML5/CSS3** - Frontend presentation
- **Composer** - Dependency management

##  Project Structure
capstone4-mvc/
├── app/
│   ├── controllers/
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── UsersController.php
│   │   └── AuthController.php
│   ├── models/
│   │   ├── Database.php
│   │   ├── Model.php
│   │   └── User.php
│   ├── views/
│   │   ├── home.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   └── users/
│   │       └── index.php
│   └── core/
│       ├── App.php
│       ├── Database.php
│       ├── Router.php
│       ├── Request.php
│       └── Session.php
├── config/
│   └── database.php
├── public/
│   ├──assets/css
│   │          └──style.css
│   └── index.php
├── vendor/ # Composer dependencies
└── README.md # This file


##  Installation Guide

### Prerequisites
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)

### Step-by-Step Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/Erfan-almrwani/capstone4-mvc.git
   cd capstone4-mvc

2. Switch to the correct branch
    git checkout capstone4-mvc-ch4

3. Install dependencies
    composer install

4. Database setup
CREATE DATABASE capstone4_mvc;
    USE capstone4_mvc;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

5. Configure environment
    cp config/database.php.example config/database.php
   # Edit config/database.php with your database credentials
6. Run the application
    # Using PHP built-in server
    php -S localhost:8000 -t public/

   # Or configure your web server to point to /public directory

## Default Login Credentials
Test User:
*Email: example@gmail.com

*Password: 123456

You can also register new users through the registration form.

## Application Routes
GET / - Home page (requires login)

GET /auth/login - Login form

POST /auth/login - Process login

GET /auth/register - Registration form

POST /auth/register - Process registration

GET /auth/logout - Logout user

GET /users/index - Users list (requires login)

## Testing the Application
1. Start the development server:
    php -S localhost:8000 -t public/

2. Access the application:
    Main application: http://localhost:8000

    Login page: http://localhost:8000/auth/login

    Registration: http://localhost:8000/auth/register

3. Test with default credentials:

    Email: example@gmail.com

    Password: 123456

## Database Schema
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

##  Core Components
Controllers
    -BaseController - Base controller with common    functionality
 
    -HomeController - Handles home page and main routes

    -AuthController - Manages authentication processes

    -UsersController - Handles user-related operations

Models
    -Model - Base model with CRUD operations

    -User - User model with authentication methods

    -Database - PDO database wrapper

Core Classes
    -App - Application bootstrap and routing

    -Router - Dynamic route handling

    -Request - HTTP request processing

    -Session - Session management

## Features Demonstration
Authentication System
    User registration with validation

    Secure login with session management

    Password hashing using PHP password_hash()

    Protected routes that require authentication

    Clean logout functionality

Database Operations
    PDO prepared statements for security

    CRUD operations for user management

    Data validation and sanitization

    Error handling and debugging

MVC Architecture
    Clear separation of concerns

    Reusable components

    Scalable structure

    Easy maintenance

#  Contributing
1.Fork the repository

2.Create a feature branch: git checkout -b feature/new-feature

3.Commit changes: git commit -am 'Add new feature'

4.Push to branch: git push origin feature/new-feature

5.Submit a pull request

# License
This project is part of the Capstone program curriculum.

# Support
This project is part of the Capstone program curriculum.

