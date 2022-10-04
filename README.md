# What the Sheet
Best thing since sliced cake.

Prerequisites
- MySQL 8+
- PHP 8.1+
- Composer

## Get started
Copy `.env.sample` into `.env` and fill in the proper values.

Install Composer dependencies.

Run the migrations on your database with:
```bash
composer run-script migrate-up
```

Run the server:
```bash
composer run-script start
```

Or run the tests:
```bash
composer test
```

Or run the tests on a freshly migrated memory database:
```bash
WTS_DB_IN_MEMORY=1 composer test
```

The tests can be run directly on the mysql database or in memory. You can enable this by setting the environment variable `WTS_DB_IN_MEMORY` to 1.

## Pipelines

### Build validation
This pipeline runs the tests, as well as Code Sniffer and rudimentary validation on the Composer configuration.

### Deploy
Connects via SSH to my server and deploys the new version.

### Run Tests in Prod
Runs every hour to run all tests (unit + integration) in production. It will send an e-mail on fail to notify me of the issue.
