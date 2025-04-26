# 📚 Library App

A demo library built with **Laravel 11**, **Inertia + Vue 3**, **Tailwind CSS / Flowbite** and MySQL.  
Customers can browse, review and check-out books; librarians manage the catalogue and mark returns.
Fully responsive and toggle button to switch between light & dark themes.

---

## Table of Contents
1. [Requirements](#requirements)  
2. [Quick start with Sail (recommended)](#quick-start-with-sail-recommended)  
3. [Running without Sail](#running-without-sail)  
4. [Default seed data](#default-seed-data)  
5. [NPM scripts](#npm-scripts)  
6. [Running tests](#running-tests)  
9. [License](#license)

---

## Requirements

| Tool  | Version |
|-------|---------|
| Docker | Desktop 4 / CLI 🐳 |
| Node   | ≥ 18 |
| Git    | any |

> *If you don’t want Docker/Sail, jump to **Running without Sail***.

---

## Quick start with Sail (recommended)

```bash
git clone https://github.com/TonyLaravel/library-app.git
cd library-app

cp .env.example .env               # tweak ports or DB creds if needed
./vendor/bin/sail up -d            # build + start containers
./vendor/bin/sail composer install
./vendor/bin/sail npm ci
./vendor/bin/sail npm run dev    
./vendor/bin/sail artisan migrate --seed

open http://localhost              # app ready!
```

---

## Running without Sail

Already have PHP 8.3, Composer & MySQL locally?

```bash
git clone https://github.com/TonyLaravel/library-app.git
cd library-app
cp .env.example .env        # set DB_* to your local DB

composer install
npm ci && npm run dev     

php artisan key:generate
php artisan migrate --seed

php artisan serve           # http://127.0.0.1:8000
```

---

## Default seed data

| Email | Password | Role |
|-------|----------|------|
| **librarian1@example.com** | `password` | Librarian | 
| **customer1@example.com**  | `password` | Customer  |
| **customer2@example.com**  | `password` | Customer  |

Plus **200 books** with random ratings & comments. 
Users are randomly assigned role.

**Manual signup** - Manual user creation is supported as well.


## Running tests

```bash
# via Sail
./vendor/bin/sail artisan test

# or native
php artisan test
```

**Feature coverage**

* Book CRUD & authorisation  
* Comments & ratings  
* Profile update / delete  

---

## License

Released under the **MIT** license – free for personal & commercial use. Enjoy!
