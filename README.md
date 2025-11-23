# 📘 NoteSquare

NoteSquare is a PHP-based blogging system supporting user accounts, posts, comments, likes, favorites, and administrative tools. The application uses native PHP, MySQL (via PDO), and a simple routing structure.

---

## ✨ Features
- User Accounts: Signup, login, logout; update profile; change password
- Roles: Admin, Editor, User with role-based access control
- Posts: Create, edit, delete; image uploads with validation; draft/published status; ownership checks; search
- Comments: Add, edit, delete with ownership checks
- Likes & Favorites: Like/dislike posts; add or remove favorites
- Admin Tools: Manage users (add, edit, delete, update role, change password); manage contact submissions; dashboard overview
- Contact Form: Submit messages; admin review and deletion

---

## 🔐 Security
- CSRF protection for all POST requests
- Output escaping to prevent XSS
- Prepared statements for SQL queries
- Password hashing with `password_hash()`
- Role-based access control and ownership checks
- Secure image uploads:
  - Size limit
  - Allowed extensions
  - MIME validation
  - Random filenames
  - Old image removal
- `.htaccess` blocking PHP execution in `uploads/`

---

## 🧰 Tech Stack
- PHP 8+
- MySQL / MariaDB (PDO)
- Bootstrap 5
- Apache (recommended)

---

## 📦 Installation
1) Clone the repository
```bash
git clone https://github.com/Jia0705/NoteSquare.git
cd NoteSquare/blog
```

2) Import the database
- Create a MySQL database named `blog`.
- Import the `blog.sql` file included in the project.

3) Configure the database (edit `config.php`)
```php
return [
    'db_host'     => 'localhost',
    'db_name'     => 'blog',
    'db_user'     => 'root',
    'db_password' => ''
];
```

4) Start the application
- Using PHP’s built-in server:
```bash
php -S localhost:8000
```
- Or run via XAMPP, WAMP, or MAMP.

---

## 📁 Project Structure
```
blog/
├── .htaccess                 # Rewrite rules (if enabled)
├── blog.sql                  # Database schema and sample data
├── config.php                # Database configuration
├── index.php                 # Routing entry point
├── includes/                 # Backend logic and form processing
│   ├── auth/                 # Authentication handlers
│   ├── comment/              # Comment operations
│   ├── contact/              # Contact form processing
│   ├── like/                 # Like/dislike actions
│   ├── post/                 # Post CRUD logic
│   ├── user/                 # User/admin actions
│   └── functions.php         # Shared utilities: DB, CSRF, helpers
├── pages/                    # User-facing pages
│   ├── home.php              # Homepage and search
│   ├── login.php             # Login page
│   ├── signup.php            # Signup page
│   ├── post.php              # Single post view
│   ├── favorites.php         # Favorites list
│   ├── manage-users.php      # Admin user management
│   ├── manage-posts.php      # Post list and filters
│   ├── manage-contacts.php   # Contact review
│   └── ...
├── parts/                    # Shared layout components
│   ├── header.php            # Navigation + head
│   ├── footer.php            # Footer
│   ├── error_message.php     # Error display component
│   ├── success_message.php   # Success display component
│   └── ...
└── uploads/                  # Uploaded post images
    ├── .htaccess             # Blocks PHP execution
    └── <image files>
```

---

## 📄 License
This project is created for academic and learning purposes.

## 👥 Contributors
Jia0705

## 🔗 Links
Repository: https://github.com/Jia0705/NoteSquare

Last Updated: November 23, 2025
