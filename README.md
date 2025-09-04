## Reproducing the issue

1. Requirements :
    - Docker Desktop installed and running
    - Git installed and set up with SSH keys

2. Clone the repository:
   ```bash
    git clone git@github.com:ClemMLD/bug-report-issue.git
    cd bug-report-issue
    ```

3. Switch to the issue branch:
   ```bash
    git checkout bug-issue
    ```

4. Build and run the Docker container:
    ```bash
    docker compose up -d --build
    ```

5. Migrate the database:
    ```bash
    docker compose exec app php artisan migrate
    ```

6. Reproducing the issue:
    - First, you need to seed the database. You should get an error saying "relation 'tests' does not exist":
    ```bash
    docker compose exec app php artisan db:seed
    ```
    - Now, to show you it worked with Laravel 11, you can downgrade the package with composer:
    ```bash
    docker compose exec app composer require laravel/framework:"^11.45"
    ```
    - Then, you can run the seeder again, and it should work without any error.
