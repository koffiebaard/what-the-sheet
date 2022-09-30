# What the Sheet
Best thing since sliced cake.

Prerequisites
- MySQL 8+ database
- PHP 8+
- Composer

## Get started
Create a database with the structure in [structure.sql](structure.sql).

Copy `.env.sample` into `.env` and fill in the proper values.

Install Composer dependencies.

Run the server:
```bash
composer run-script start
```

Or run the tests:
```bash
composer test
```

The tests can be run directly on the mysql database or in memory. You can enable this by setting the environment variable `WTS_DB_IN_MEMORY` to 1.

## Pipeline
The pipeline runs the tests, as well as Code Sniffer and rudimentary validation on the Composer configuration.
