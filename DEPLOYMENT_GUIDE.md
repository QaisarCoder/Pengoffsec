# Production Deployment Checklist (Ubuntu/Debian)

## 1. Server Prerequisites
- Install: Nginx, PHP 8.2+ (FPM), MySQL, Composer, Node.js/npm, Git.

## 2. MySQL Database Setup
```bash
mysql -u root -p
CREATE DATABASE your_production_db_name;
CREATE USER 'your_production_db_user'@'localhost' IDENTIFIED BY 'your_production_db_password';
GRANT ALL PRIVILEGES ON your_production_db_name.* TO 'your_production_db_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 3. Project Deployment
1.  Clone repo: `git clone <repository_url> /var/www/pm-project`
2.  Install dependencies:
    ```bash
    cd /var/www/pm-project
    cp .env.production .env
    composer install --no-dev --optimize-autoloader
    npm install
    npm run build
    ```
3.  Set permissions:
    ```bash
    chown -R www-data:www-data /var/www/pm-project/storage /var/www/pm-project/bootstrap/cache
    chmod -R 775 /var/www/pm-project/storage /var/www/pm-project/bootstrap/cache
    ```
4.  Run Migrations: `php artisan migrate --force`

## 4. Nginx Configuration
Create `/etc/nginx/sites-available/your-domain.com`:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/pm-project/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; # Adjust version
    }
}
```
Enable site, check config, restart Nginx.

## 5. Finalize
- Enable HTTPS (Certbot).
- Run: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
