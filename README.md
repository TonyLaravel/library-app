# 📚 Library App

A demo library built with **Laravel 11**, **Inertia + Vue 3**, **Tailwind CSS / Flowbite** and MySQL.  
Customers can browse, review and check-out books, while librarians manage the catalogue and mark returns.  
Fully responsive, with a toggle for light / dark themes.

---

## Table of Contents
1. [Requirements](#requirements)  
2. [Quick start with Sail (recommended)](#quick-start-with-sail-recommended)  
3. [Running without Sail](#running-without-sail)  
4. [Default seed data](#default-seed-data)  
5. [Running tests](#running-tests)  
6. [License](#license)

---

## Requirements

| Tool  | Version |
|-------|---------|
| Docker | Desktop 4 / CLI  |
| Node   | ≥ 18 |
| Git    | any |

> *If you don’t want Docker/Sail, jump to **Running without Sail***.

---

## Quick start with Sail (recommended)

    git clone https://github.com/TonyLaravel/library-app.git
    cd library-app
    
    cp .env.example .env               # tweak ports or DB creds if needed
    ./vendor/bin/sail up -d            # build + start containers
    ./vendor/bin/sail composer install
    ./vendor/bin/sail npm ci
    ./vendor/bin/sail npm run dev
    ./vendor/bin/sail artisan migrate --seed
    
    open http://localhost              # app ready!

---

## Running without Sail

Already have PHP 8.3, Composer & MySQL locally?

    git clone https://github.com/TonyLaravel/library-app.git
    cd library-app
    cp .env.example .env        # set DB_* to your local DB
    
    composer install
    npm ci && npm run dev
    
    php artisan key:generate
    php artisan migrate --seed   # needs internet to fetch book data
    
    php artisan serve            # http://127.0.0.1:8000

---

## Default seed data

### Users

| Email | Password | Role |
|-------|----------|------|
| **librarian1@example.com** | `password` | Librarian |
| **customer1@example.com**  | `password` | Customer  |
| **customer2@example.com**  | `password` | Customer  |

*(You can also register new accounts manually.)*

### Books  

`BookSeeder` calls the **Open Library** API and inserts ≈ 200 random fiction titles.  
Twelve are flagged **featured**. All start *Available*; loans update that status.

*(You can also add books manually.)*

---

## Running tests

Via Sail:

    ./vendor/bin/sail artisan test

Or natively:

    php artisan test

> Feature coverage: Book CRUD & role gates  • Comments & ratings • Profile update / delete

---

## License

Released under the **MIT** license – free for personal & commercial use. Enjoy! 🎉
