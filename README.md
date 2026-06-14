# Hepsuz - Laravel E-Commerce System

**Developer:** Oğuz (Student ID: 20222022406)
**University:** Nişantaşı University
**Course:** Advanced Web Programming
**Instructor:** Yüksel Çelik

Hepsuz is a modern, responsive, and robust B2C e-commerce web application built with **Laravel 12**, styled using **Tailwind CSS v4**, and bundled with **Vite**. It features an elegant front-end shopping interface, a dynamic session-based cart system, a highly advanced customer profile dashboard, and a comprehensive administration panel for managing the entire catalog and order logistics.

---

## About the Project

Hepsuz is designed to provide a seamless shopping experience for customers while offering a secure and efficient back-office workflow for store managers. The project applies modern Laravel development patterns:

* **MVC Pattern & Service Layer:** The application cleanly separates front-facing customer interfaces from secure back-office administrative logic.
* **Advanced Eloquent Relationships:** The database schema elegantly links Categories, Products, Orders, Order Items, Customer Addresses, and Masked Credit Cards through optimized relational structures.
* **Vibrant Front-end Experience:** Built with Tailwind CSS v4 and Vite, the storefront delivers a highly responsive, modern grid-based product display with lightning-fast asset compilation.
* **Customer Loyalty & Management:** Unlike standard auth stubs, Hepsuz features a custom-built Customer Dashboard where users can manage multiple delivery addresses, view saved (masked) credit cards, and track their order statuses with visual badges.
* **Administrative Operations:** The admin interface features secure access via custom middleware (`is_admin`), enabling store managers to update order fulfillment statuses (Pending, Shipped, Completed), manage product stock/pricing, upload product imagery, and control category hierarchies.

---

## Key Features

### Front-End / Customer Side
* **Interactive Storefront:** Modern product cards with direct click-throughs, dynamic category filtering, and responsive grid layouts.
* **Advanced Shopping Cart:** Session-based cart system with real-time total calculations, quantity adjustments, and item removal.
* **Secure Checkout Flow:** Seamless address and billing form converting cart sessions into permanent database orders.
* **Order Tracking (`/profile`):** Detailed history of past orders with color-coded status badges inside the customer dashboard.
* **Address Book:** Dedicated section to add, edit, and delete multiple delivery addresses.
* **Wallet:** Safely store and manage masked credit card details (PCI-DSS compliant UI logic, saving only the last 4 digits).

### Back-End / Admin Panel (`/admin`)
* **Secure Access:** Protected by a dedicated Admin Middleware.
* **Category Management:** Create, edit, and delete product categories to organize the store.
* **Product Management:** Complete catalog control including dynamic image uploads (stored securely in `storage/app/public`), pricing, and stock inventory management.
* **Logistics & Order Processing:** Track incoming customer orders, view detailed purchased items, and seamlessly update fulfillment statuses.

---

## Technical Stack

* **Framework:** Laravel 12.x
* **PHP Version:** PHP 8.2+ 
* **Styling:** Tailwind CSS v4
* **Bundler:** Vite
* **Database:** MySQL (Relational Database Architecture)
* **Development Environment:** macOS, XAMPP / Vite Development Server

---

## Default Test Accounts

To easily evaluate the administrative and customer features without registering a new account, use the following credentials:

**Administrator Account**
* **Email:** admin1@admin.com
* **Password:** admin123
* **Dashboard Access:** `http://localhost:8000/admin`

**Standard Customer Account**
* **Email:** user@user.com
* **Password:** user1234
* **Storefront Login:** `http://localhost:8000/login`

---

## Installation & Setup

Follow these steps to set up the project locally on your machine:

### Prerequisites
Ensure you have the following installed:
* **PHP** (>= 8.2) or **XAMPP** (for macOS/Windows)
* **Composer**
* **Node.js** (includes npm)
* **MySQL** Database

### Step 1: Clone and Navigate
Clone the repository to your local directory and navigate into it:
```bash
git clone [https://github.com/drfloowz/hepsuz.git](https://github.com/drfloowz/hepsuz.git)
cd hepsuz
```


### Step 2: Database Setup
1- Open your local database manager (e.g., phpMyAdmin via XAMPP).
2- Create a new, empty database named laravelproject with utf8mb4_unicode_ci collation.
3- Duplicate the .env.example file, rename it to .env, and configure your database credentials:

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelproject
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Install Dependencies & Setup
Run the following commands sequentially to install packages, generate keys, and link storage for product images:

```bash
composer install
npm install
php artisan key:generate
php artisan storage:link
```
### Step 4: Run Migrations
Build the database schema by running:
```bash
php artisan migrate 
```

### Step 5: Run the Application
To launch the application, you need to run the backend and frontend compilers concurrently. Open two separate terminal tabs and run:

Terminal 1 (Backend):
php artisan serve

Terminal 2 (Frontend/Tailwind):
npm run dev
``` 
## 📂 Project Structure

Here is an overview of the key directories and files that make up the Hepsuz e-commerce architecture:

```text
hepsuz/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Core logic (Admin, Profile, Product, Cart, Checkout)
│   │   └── Middleware/     # Security and access layers (e.g., AdminMiddleware)
│   └── Models/             # Eloquent Models (User, Product, Order, Address, etc.)
├── database/
│   ├── migrations/         # Database schema definitions and relational blueprints
│   └── seeders/            # Database seeders for default test accounts
├── public/
│   ├── build/              # Compiled Vite assets (optimized Tailwind CSS/JS)
│   └── favicon.png         # Hepsuz brand icon
├── resources/
│   └── views/              # Blade template ecosystem
│       ├── admin/          # Admin dashboard, category, and product management UI
│       ├── layouts/        # Master layouts (Storefront, Admin panel, Auth forms)
│       ├── profile/        # Customer dashboard, addresses, and order history
│       └── checkout/       # Secure order placement and payment views
├── routes/
│   └── web.php             # Centralized routing (Storefront, Authenticated & Admin groups)
├── .env.example            # Template for environment variables
├── README.md               # Project documentation
├── tailwind.config.js      # Tailwind CSS configuration and theme settings
└── vite.config.js          # Vite asset bundler configuration
