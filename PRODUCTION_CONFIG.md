# Production Database Configuration Required

To finalize Phase 2 and 3, you must configure your production `.env` file with the following variables. Do NOT commit this file to Git.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_production_db_name
DB_USERNAME=your_production_db_user
DB_PASSWORD=your_production_db_password
```

## Data Migration Procedure (SQLite to MySQL)

Since we are moving from SQLite to MySQL, I have prepared this safe procedure:

1.  **Backup**: Ensure you have a backup of `database/database.sqlite`.
2.  **MySQL Setup**: Ensure the database user has permissions for `CREATE`, `DROP`, `ALTER`, `SELECT`, `INSERT`, `UPDATE`, `DELETE`, and `INDEX`.
3.  **Migration**:
    - Update your `.env` to the MySQL credentials above.
    - Run: `php artisan migrate` (Laravel will create the tables in MySQL).
4.  **Data Transfer**:
    - For small datasets, you can use a tool like `laracasts/sqlite-to-mysql` or export SQLite data to SQL/CSV and import it.
    - I recommend running the migration and verifying table structures before importing data.
