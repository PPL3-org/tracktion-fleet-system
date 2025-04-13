# Tracktion Fleet Management System

## Getting Started
Follow these steps to set up and run the project on your local machine.

### Prerequisites
Make sure you have the following installed:
- [Node.js](https://nodejs.org/) & npm
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- PHP 8.4

### 1. Clone the Repository
```sh
git clone https://github.com/PPL3-org/tracktion-fleet-system.git
cd tracktion-fleet-system
```

### 2. Install Dependencies
#### Node.js dependencies:
```sh
npm install
```

#### PHP dependencies:
```sh
composer install
```

### 3. Set Environment Variables
Create a `.env` file in the root directory and configure your environment variables as needed. You can use `.env.example` as a reference:
```sh
cp .env.example .env
```
Then, update the `.env` file with your credentials and settings and generate your application key
```sh
php artisan key:generate
```

### 4. Run the Application
Start the development server with:
```sh
npm run dev
```

Your application should now be running locally

---

## Core Models
This system is built around the following core models:
- **Truck**
- **Driver**
- **Shipment**
- **Report**

The model, factory, migration, and controller files for these entities have already been created.
