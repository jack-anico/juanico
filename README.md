# Juanico Web App

A RESTful API built in vanilla PHP (no framework), following PSR-style conventions with manual autoloading.

## Requirements

- PHP >= 8.1
- MySQL / MariaDB (or your DB of choice)
- Apache or Nginx

## Project Structure

```
project-root/
├── public/              # Web root — only this folder is exposed to the internet
│   ├── index.php        # Front controller / router entry point
│   └── .htaccess        # Apache rewrite rules
├── src/                 # Application code (App\ namespace, manually autoloaded)
│   ├── Controllers/      # Handle requests, call services, return JSON
│   ├── Services/         # Business logic
│   ├── Repositories/     # Database access layer
│   ├── Models/           # Data structures / entities
│   ├── Middleware/       # Auth, CORS, rate limiting
│   ├── Validators/       # Input validation
│   ├── Core/             # Router, Request, Response, Database, Container
│   ├── Exceptions/       # Custom exception classes
│   └── Helpers/          # Shared helper functions
├── config/               # App, database, route, and CORS configuration
├── database/
│   ├── migrations/       # Schema migrations
│   └── seeds/            # Seed data
├── tests/
│   ├── Unit/
│   └── Integration/
├── storage/
│   ├── logs/
│   ├── cache/
│   └── uploads/
├── .env.example          # Environment variable template
└── .gitignore
```

## Setup

1. Clone the repository
   ```bash
   git clone <repo-url>
   cd project-root
   ```

2. Copy the environment file and fill in your values
   ```bash
   cp .env.example .env
   ```

3. Create the database and run migrations
   ```bash
   # e.g. import database/schema.sql, or run your migration scripts
   ```

4. Point your web server's document root at `public/`

   **Using PHP's built-in server (for local dev):**
   ```bash
   php -S localhost:8000 -t public
   ```

5. Test the scaffold
   ```bash
   curl http://localhost:8000/
   ```

## API Conventions

- All responses are JSON: `Content-Type: application/json`
- Standard response shapes:
  ```json
  { "data": { } }
  { "error": { "message": "...", "code": "..." } }
  ```
- HTTP verbs map to CRUD actions (GET, POST, PUT/PATCH, DELETE)
- Routes are defined in `config/routes.php`

## Notes

- No Composer / no framework — autoloading is handled manually via `spl_autoload_register` in `public/index.php`.
- Only `public/` should ever be reachable via the web server; `src/`, `config/`, `.env`, and `storage/` must stay outside the document root's exposure.

## License

TBD