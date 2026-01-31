# Fintech Task API

## Base URL

base_url = http://localhost:8000/

## Getting Started

### Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** and **npm** (for frontend assets)
- **MySQL** or **PostgreSQL** (database)
- **Git** (for cloning the repository)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd fintech-task
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Edit the `.env` file and configure your database connection:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fintech_task
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Build Frontend Assets (if needed)**
   ```bash
   npm run build
   ```

9. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   
   The API will be available at `http://localhost:8000`

### API Documentation

Postman collections are available in the `postman/` directory:
- `postman_fintech_user.json` - User management endpoints
- `postman_fintech_account.json` - Account management endpoints
- `postman_fintech_transaction.json` - Transaction management endpoints
- For complete documentation - https://documenter.getpostman.com/view/24296959/2sBXVoA8c5

Import these collections into Postman to test the API endpoints.

**Note:** The prompt used to generate these Postman collections is available in `postman_prompt.txt` for reference.

### Project Structure

- `app/Http/Controllers/Api/` - API Controllers
- `app/Services/` - Business logic services
- `app/Repositories/` - Data access layer
- `app/Contracts/Repositories/` - Repository interfaces
- `app/Http/Resources/` - API response resources
- `app/Http/Requests/` - Form request validation
- `routes/api.php` - API routes definition

### ERD diagram
https://drive.google.com/file/d/1Y3kMYU8_3elSC2h8MocT3yIi5BK4v_nD/view?usp=drive_link

**Note:** Key database design decisions and their rationale are documented in `erd_design_decisions.txt`.