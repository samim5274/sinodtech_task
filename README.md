![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![License](https://img.shields.io/badge/License-MIT-green)

# Sales, Inventory & CRM System

A complete **Sales, Inventory, and Customer Relationship Management (CRM)** system built with **Laravel** and **Blade Templates**.

This application helps businesses manage products, sales, inventory, customer engagement, employee follow-up activities, KPI tracking, and automated invoice generation.

---

## 🚀 Features

### 1. Sales & Inventory Management

#### Product Management

* Product Name
* SKU Management
* Product Price
* Stock Quantity Tracking

#### Inventory Control

* Record product sales
* Automatic stock deduction after sales
* Prevent sales when stock is insufficient
* Real-time inventory updates

---

### 2. Customer Relationship Management (CRM)

#### Customer Purchase History

Maintain complete customer purchase records:

* Total purchases
* Purchase frequency
* Last purchase date
* Customer sales history

#### Lost Customer Detection

Automatically identify inactive customers who have not purchased within a configurable period (default: **90 days**).

#### Customer Re-engagement

* Send promotional emails to inactive customers
* Simulated SMS support
* Marketing campaign functionality

#### Employee Assignment

* Assign inactive customers to employees
* Track employee follow-up activities

#### KPI Tracking

When an assigned inactive customer makes a new purchase:

* Employee KPI score increases automatically
* Performance tracking available

---

### 3. Invoice System

After a successful purchase:

* Generate HTML/PDF invoices
* Automatically send invoices via email

---

## 🛠 Technology Stack

| Technology     | Version              |
| -------------- | -------------------- |
| PHP            | 8.x                  |
| Laravel        | 10                   |
| MySQL          | 8+                   |
| Blade Template | Frontend             |
| Tailwind CSS   | UI Design            |
| JavaScript     | Client-side Features |
| Laravel Mail   | Email Service        |

---

## 📦 Installation

Clone the repository:

```bash
git clone https://github.com/samim5274/sinodtech_task.git
cd sinodtech_task
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure database in `.env`:

```env
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

## 🌱 Seed Data

The project includes realistic sample data through seeders.

- ProductSeeder
- CustomerSeeder
- EmployeeSeeder
- SaleSeeder
- TransactionSeeder

Run:

```bash
php artisan migrate:fresh --seed
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Create storage link:

```bash
php artisan storage:link
```

Run the application:

```bash
php artisan serve
```

---

## 📧 Mail Configuration

Configure mail settings inside `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📊 Business Flow

### Sales Flow

Product Selection
→ Stock Validation
→ Sale Record Creation
→ Stock Deduction
→ Invoice Generation
→ Email Invoice

### CRM Flow

Customer Purchase Tracking
→ Lost Customer Detection
→ Employee Assignment
→ Promotional Email
→ Customer Purchase
→ Employee KPI Increase

---

## 📂 Project Structure

```text
app/
├── Models
├── Http/Controllers
├── Mail
├── Jobs
├── Services

resources/
├── views/
│   ├── sales/
│   ├── customers/
│   ├── products/
│   └── invoices/

database/
├── migrations/
├── seeders/
```

---

## 🔐 Key Business Rules

* Sales cannot be completed if stock is unavailable.
* Inventory updates automatically.
* Lost customers are detected dynamically.
* KPI updates automatically after customer reactivation.
* Invoice email is generated after successful sales.

---

## Requirement Checklist

| Requirement | Status |
|------------|--------|
| Laravel | ✅ |
| MySQL | ✅ |
| Blade | ✅ |
| Product Management | ✅ |
| Sales Recording | ✅ |
| Stock Deduction | ✅ |
| Prevent Insufficient Stock | ✅ |
| Purchase History | ✅ |
| Purchase Frequency | ✅ |
| Last Purchase Date | ✅ |
| Lost Customer Detection | ✅ |
| Promotional Email | ✅ |
| Employee Assignment | ✅ |
| KPI Tracking | ✅ |
| Mailtrap SMTP | ✅ |
| HTML/PDF Invoice | ✅ |
| README | ✅ |
| GitHub Repository | ✅ |
| Environment Setup | ✅ |
| Database Migrations | ✅ |
| Seeders | ✅ |
| Products Seeder | ✅ |
| Customers Seeder | ✅ |
| Employees Seeder | ✅ |
| Sales Seeder | ✅ |
| Transactions Seeder | ✅ |

### Final Assessment

**Mandatory requirements:** **100% Complete** ✅

**Bonus features:**
- Email Invoice: ✅
- Multi-Branch Support: ❌ (optional)
- E-Commerce REST API: ❌ (optional)

---

## 👨‍💻 Developer

**Samim Hossain**

GitHub: https://github.com/samim5274

Portfolio: https://samim-hossen.vercel.app/

---

## 📄 License

This project is developed for technical assessment and educational purposes.
