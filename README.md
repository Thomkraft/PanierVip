# 🛒 Paniervip

Paniervip is a web application developed with **Symfony** (backend), designed to manage VIP baskets in an e-commerce or event context.

## 🚀 Technologies Used

- ⚙️ Language: [Symfony](https://symfony.com/)
- 🛢 Database: MySQL
- 📦 PHP Dependency Manager: Composer
- 📦 JS Dependency Manager: NPM/Yarn

## 🛠 Prerequisites

- PHP 8.1+
- Composer
- Node.js (v16 or higher)
- MySQL 8+
- Symfony CLI (optional but recommended)

## 📦 Project Installation

```bash
git clone https://github.com/Thomkraft/PanierVip.git
cd paniervip
composer install
npm install
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
npm run watch

```

## 📁 Database Configuration

Database name: 'paniervip'

in `.env` file (or `.env.local`) :

```env
DATABASE_URL="mysql://root@127.0.0.1:3306/paniervip?serverVersion=9.1.0&charset=utf8mb4"
```

## 🔐 Admin account

- Email : minh@ad.fr
- Password : admin


## 🧩 Key features

- Secure admin interface
- Shopping list creation
- Product, quantity, and price management
- Graphs and statistics
