# zumar.bulsho.net

Zumar Foundation organizational database — built on the existing Metronic/PHP template (auth, menu, session, layout) and extended with the modules from the *Organizational Database Design & Data Collection Guideline* v2.0.

## What is kept from the template

- Login / logout / change password
- Role-based sidebar (`topmenu`, `pages`, `pagepermissions`)
- Metronic layout4, `example-page.php`
- Default admin user

## What was added from the guideline

Project-hub design: every finance, HR, procurement, MEAL and program record is tagged to a `Project`.

- Master data: countries, locations, sectors, partners / accreditations
- Projects with auto codes (`SO-WASH-014-2025`)
- Orphan Support (ORPH-01 / ORPH-02), Education, WASH, Health, Infrastructure, Livelihoods, Relief, Peace & Development
- Finance (budgets, expenses, donor funding, disbursements)
- HR (staff, assignments, recruitment, policy acknowledgements)
- Procurement (vendors, PR, PO, GRN) — approval sits with Operations Manager
- MEAL and Research
- Standard reports on `reports.php`
- Audit log on every insert/update/delete
- Org-chart roles (Executive Director, Finance, Program, HR, Operations, …)

Restricted modules (mental health, legal aid, complaints, mediation) are limited to Administrator, Executive Director, HR Manager and M&E Officer.

## Database

```bash
mysql -h 127.0.0.1 -u root -p -e "CREATE DATABASE IF NOT EXISTS zumardb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -h 127.0.0.1 -u root -p zumardb < _core/sql/install.sql
mysql -h 127.0.0.1 -u root -p zumardb < _core/sql/zumar_schema.sql
```

Login: `admin` / `admin123`

Config: `_core/sql_localhost.php` and `_core/sql_zumar.bulsho.net.php` (database `zumardb`, user `zumardbuser`).

## Local run

```bash
php -S localhost:8000
```

App: http://localhost:8000

## Docker

The app container has no MySQL of its own. It joins the shared Coolify network and uses the common database server (`zekubw4fjelwjqlrepe23ilj`), database `zumardb`, user `zumardbuser`.

Import schema once on that server if the tables are not there yet:

```bash
mysql -h zekubw4fjelwjqlrepe23ilj -u zumardbuser -p zumardb < _core/sql/install.sql
mysql -h zekubw4fjelwjqlrepe23ilj -u zumardbuser -p zumardb < _core/sql/zumar_schema.sql
```

```bash
cp .env.example .env
docker compose up --build
```

Login: `admin` / `admin123`
