E-Learning Site Project
Welcome to my E-Learning Site Project! 🚀
A modern, secure, and feature-rich online learning platform built with PHP and MySQL. Designed for educators and learners, this platform offers a seamless experience for course management, user authentication, and secure payments—with robust Two-Factor Authentication (2FA) for enhanced security.

🌟 Key Features
User Authentication: Secure registration, login, and password reset with integrated 2FA.

Two-Factor Authentication (2FA):

2FA required for login, registration, and password reset flows

Protects user accounts with an extra layer of security

Course Catalog: Browse, search, and view detailed course pages.

Payment Integration: Seamless payment gateway for course enrollments.

Admin Dashboard: Manage courses, users, and site content with ease.

Responsive Design: Works beautifully on desktop and mobile.

Contact & Support: Built-in contact form and support information.

Privacy & Terms: Ready-made privacy policy and terms of service pages.

🔒 About 2FA in This Project
Security is a top priority.
This platform uses Two-Factor Authentication (2FA) to protect user accounts during:

Login: Users must enter a verification code (via email or authenticator app) after their password.

Registration: New users verify their identity with a 2FA code before completing registration.

Password Reset: 2FA is required to confirm the identity of users requesting a password reset.

2FA methods supported:

Email-based OTP (default)

Ready for extension to authenticator apps (TOTP)

🗂️ Project Structure

E-learning_site_project/
│
├── admin/           # Admin panel and management scripts
├── api/             # Backend API endpoints
├── controllers/     # Business logic controllers
├── includes/        # Shared PHP includes & config
├── models/          # Database models
├── payment/         # Payment processing
├── resources/       # Static resources (images, CSS, JS)
├── sql_scripts/     # Database setup scripts
├── uploads/         # User-uploaded files
├── user/            # User dashboard & profile
├── vendor/          # Composer dependencies
│
├── index.php        # Landing page
├── courses.php      # Course listing
├── course_detail.php# Course details
├── login.php        # User login (with 2FA)
├── register.php     # User registration (with 2FA)
├── password_reset.php # Password reset (with 2FA)
├── about.php        # About page
├── contact.php      # Contact form
├── privacy_policy.php
├── terms_of_service.php
└── ...and more!


🚀 Getting Started
Prerequisites
PHP 7.4+

MySQL/MariaDB

Composer

Web server (Apache/Nginx)

SMTP or email service for sending OTPs (for 2FA)

1. Installation
Clone this repo:
git clone https://github.com/gagan-long/E-learning_site_project.git
cd E-learning_site_project

2. Install dependencies:
composer install

3. Configure your environment:

Set up your database and update connection details in the config files (includes/config.php or similar).

Configure your email settings for 2FA OTP delivery.

Import the SQL schema:
mysql -u username -p database_name < sql_scripts/database.sql

4. Run the app:

Place the project in your web server’s root directory.

Open http://localhost/E-learning_site_project in your browser.

🛠️ Technologies Used
Backend: PHP

Database: MySQL

Frontend: HTML, CSS, JavaScript

Dependencies: Composer

Security: Two-Factor Authentication (2FA) via email OTP

🤝 Contributing
Have ideas or found a bug?
Feel free to open an issue or submit a pull request.
All contributions are welcome!

📄 License
Currently, this project does not specify a license.
Contact me if you’d like to use it for commercial purposes or large-scale deployments.

🙏 Acknowledgements
Thanks to the open-source PHP community and everyone who inspires online learning!

Made with ❤️ by Gagan Long
If you like this project, don’t forget to ⭐ star the repo!

Feel free to add screenshots, a demo link, or more details about your 2FA implementation for extra polish!