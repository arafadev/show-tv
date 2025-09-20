# Show TV

---

## Project Setup

Follow these steps to get the project up and running on your local machine.

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/arafadev/show-tv.git
    cd show-tv
    ```

2.  **Install Composer dependencies:**
    ```bash
    composer install
    ```

3.  **Create `.env` file:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure `.env` file:**
    Make sure to update your database credentials in the `.env` file:
    ```
    DB_DATABASE=your_database
    DB_USERNAME=your_db_user
    DB_PASSWORD=your_db_password
    ```

6.  **Run migrations and seed the database:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Run the development server:**
    ```bash
    php artisan serve
    ```

Alternatively, if you are using Laragon or Herd, you can open the project directly in your browser:
`http://show-tv.test`

---

## Login Credentials

Use these credentials to access the admin dashboard:

* **Email:** `arafa.dev@gmail.com`
* **Password:** `123456789`