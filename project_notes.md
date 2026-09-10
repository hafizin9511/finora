# Finora — Project Notes

## 1. Project Overview

**Project name:** Finora

**Purpose:**
A multi-user personal finance management system that helps users track and understand their finances.

### Initial MVP

The first version will handle:

- User accounts / authentication
- Financial accounts
- Income
- Expenses
- Transactions
- Categories
- Financial dashboard

The primary goal is:

> Track and understand finances.

Future modules may include:

- Budgets
- Financial goals
- Debt management
- Investments
- Cash-flow forecasting
- Financial insights
- Financial health score

---

## 2. Development Environment

The project is being developed on an existing laptop using:

| Component         | Version / Tool |
| ----------------- | -------------- |
| Laravel           | 12.65.0        |
| PHP               | 8.2.29         |
| MySQL             | 8.0.30         |
| Composer          | 2.4.1          |
| Node.js           | 18.8.0         |
| npm               | 8.18.0         |
| Local environment | Laragon        |
| Code editor       | VS Code        |
| Browser           | Chrome         |

### Important environment decision

Composer **must not be upgraded without discussion first**.

The existing Composer version is:

```text
Composer 2.4.1
```

It is being kept intentionally because there are existing projects on this laptop that may depend on the current development environment.

Do not modify PHP, Composer, Node.js, MySQL, or Laragon unnecessarily.

---

## 3. Project Location

Finora is located at:

```text
C:\laragon\www\finora
```

Laravel version has been verified with:

```bash
php artisan --version
```

Result:

```text
Laravel Framework 12.65.0
```

---

## 4. Technology Stack

### Backend

- Laravel 12
- PHP 8.2

### Database

- MySQL 8.0

### Frontend

- Laravel Blade
- Livewire 4.4.0
- Tailwind CSS 4
- Vite
- JavaScript / Alpine.js where appropriate

### Authentication

Authentication work has started using:

- Laravel Fortify 1.38.0
- Livewire 4.4.0

Fortify is currently installed locally but has **not yet been committed or pushed**.

### Development

- Laragon
- VS Code
- Chrome
- Node.js / npm
- Git / GitHub

We are intentionally avoiding a separate React frontend and separate API backend for the initial version.

---

## 5. Application Structure

Initial application flow:

```text
Login
  │
  ▼
Dashboard
  │
  ├── Accounts
  │
  ├── Transactions
  │
  ├── Categories
  │
  └── Reports
```

---

## 6. Database

Initial application tables:

```text
users
accounts
categories
transactions
```

Laravel framework tables are also present, including the migration, cache, jobs, and session-related tables created by the default Laravel migrations.

Potential future tables:

```text
budgets
budget_items
goals
goal_contributions
debts
debt_payments
investments
investment_transactions
recurring_transactions
financial_snapshots
notifications
```

### Important database principle

Financial data belongs to a specific user.

For example:

```text
accounts.user_id
categories.user_id
transactions.user_id
```

A user must never be able to access another user's financial records.

---

## 7. Account Concept

An account represents where money is held.

Examples:

```text
Maybank Savings
CIMB Savings
Cash
Touch 'n Go
Credit Card
```

Initial account types:

```text
BANK
CASH
EWALLET
CREDIT_CARD
OTHER
```

We use an opening balance plus transactions to determine the current balance rather than making the current balance a separate source of truth.

Conceptually:

```text
Opening Balance
+ Income
- Expenses
+ Transfers In
- Transfers Out
= Current Balance
```

### `accounts` table

Current fields:

```text
id
user_id
name
type
opening_balance
currency
is_active
timestamps
```

The `user_id` foreign key uses cascade deletion.

---

## 8. Category Concept

Categories classify income and expenses.

Examples:

```text
Income
├── Salary
├── Freelance
└── Bonus

Expense
├── Food
├── Transport
├── Housing
└── Utilities
```

### `categories` table

Current fields:

```text
id
user_id
name
type
is_active
timestamps
```

Category types currently planned:

```text
INCOME
EXPENSE
```

Categories are user-owned.

---

## 9. Transaction Concept

Initial transaction types:

```text
INCOME
EXPENSE
TRANSFER
```

Examples:

```text
Salary
+ RM8,500
Maybank
Income → Salary
```

```text
Lunch
- RM25
Maybank
Expense → Food
```

Transfers are not counted as expenses.

A transfer between accounts is represented by two linked transaction records:

```text
Maybank
- RM1,000

        ↓

Savings
+ RM1,000
```

Both records share a transfer identifier.

### `transactions` table

Current fields:

```text
id
user_id
account_id
category_id
type
amount
transaction_date
description
transfer_id
timestamps
```

### Transaction rules

Amounts are stored as positive values.

```text
INCOME   → amount = positive
EXPENSE  → amount = positive
TRANSFER → amount = positive
```

The transaction type and transfer direction determine how the amount affects the account balance.

Planned application rules:

```text
INCOME   → category required
EXPENSE  → category required
TRANSFER → category normally null
amount   → must be greater than zero
```

Transfers use a nullable UUID `transfer_id` shared by the two sides of the transfer.

The transaction migration uses:

```text
account_id  → restrictOnDelete
category_id → nullOnDelete
```

This protects financial history when accounts are deleted and preserves transactions if a category is removed.

---

## 10. Current Eloquent Models

Created models:

```text
app/Models/Account.php
app/Models/Category.php
app/Models/Transaction.php
```

`User.php` has been updated with:

```text
accounts()
categories()
transactions()
```

### Relationships

```text
User
 ├── hasMany(Account)
 ├── hasMany(Category)
 └── hasMany(Transaction)

Account
 ├── belongsTo(User)
 └── hasMany(Transaction)

Category
 ├── belongsTo(User)
 └── hasMany(Transaction)

Transaction
 ├── belongsTo(User)
 ├── belongsTo(Account)
 └── belongsTo(Category)
```

The models were verified successfully with Laravel Tinker.

Current record counts:

```text
User::count()        → 0
Account::count()     → 0
Category::count()    → 0
Transaction::count() → 0
```

No test financial records have been inserted.

---

## 11. Git / GitHub

Repository:

```text
https://github.com/hafizin9511/finora
```

Current branch:

```text
main
```

GitHub remote:

```text
origin
```

`.env` is correctly ignored by Git:

```text
.gitignore:3:.env
```

### Git checkpoints

Current Git history includes:

```text
b2b51f3 — Add Finora financial data models and migrations
8d46b73 — Install Livewire
```

The latest GitHub checkpoint is:

```text
8d46b73 — Install Livewire
```

### Current uncommitted local changes

Laravel Fortify has been installed locally.

Current uncommitted changes are:

```text
composer.json
composer.lock
```

Fortify has **not yet been committed or pushed**.

The intended next checkpoint commit is:

```text
Install Laravel Fortify
```

Do not assume this commit exists until Git confirms it.

---

## 12. Authentication Progress

Authentication scaffolding is currently being prepared.

Installed locally:

```text
Livewire 4.4.0
Laravel Fortify 1.38.0
```

Fortify installation brought in authentication-related dependencies, including Laravel Passkeys and supporting WebAuthn/2FA packages.

No authentication routes, views, or Fortify configuration have been intentionally configured yet.

### Important

Do not run:

```text
laravel new
```

inside the existing Finora project.

Finora is already an existing Laravel application with database migrations and models. Authentication must be added to the existing application without recreating the project.

---

## 13. Dashboard

Initial dashboard should provide:

```text
Total Balance
Income This Month
Expenses This Month
Net Cash Flow
```

It should also display:

```text
Spending by Category
Recent Transactions
Account Balances
```

The dashboard should focus on helping the user understand their financial situation rather than simply displaying raw data.

---

## 14. Development Principles

1. Keep the application simple initially.
2. Do not install unnecessary software.
3. Do not modify the existing development environment without a reason.
4. Financial calculations must have a clear source of truth.
5. Financial records should be traceable.
6. User financial data must be isolated from other users.
7. Build the MVP before adding advanced features.
8. Prefer maintainability over unnecessary technical complexity.
9. Review dependency changes before committing them.
10. Keep working Git checkpoints before major development stages.

---

## 15. Completed Work

- [x] Defined initial product concept
- [x] Defined MVP scope
- [x] Reviewed existing development environment
- [x] Selected Laravel-based architecture
- [x] Confirmed PHP 8.2.29
- [x] Confirmed MySQL 8.0.30
- [x] Confirmed Node.js and npm
- [x] Confirmed Composer 2.4.1
- [x] Decided not to update Composer
- [x] Created Laravel project
- [x] Confirmed Laravel 12.65.0
- [x] Started MySQL in Laragon
- [x] Created `finora` database in phpMyAdmin
- [x] Configured Laravel `.env` for MySQL
- [x] Verified Laravel → MySQL connection
- [x] Ran initial Laravel migrations
- [x] Created Account model and migration
- [x] Created Category model and migration
- [x] Created Transaction model and migration
- [x] Designed database relationships
- [x] Ran Finora migrations successfully
- [x] Verified tables in phpMyAdmin
- [x] Added Eloquent model relationships
- [x] Verified models using Tinker
- [x] Connected project to GitHub
- [x] Created database/model Git checkpoint
- [x] Pushed database/model checkpoint to GitHub
- [x] Installed Livewire 4.4.0
- [x] Committed and pushed Livewire checkpoint
- [x] Installed Laravel Fortify 1.38.0 locally

---

## 16. Current Checkpoint

**STOPPED HERE**

The current local state is:

```text
Finora
Laravel 12.65.0
PHP 8.2.29
MySQL 8.0.30
Composer 2.4.1
Livewire 4.4.0
Fortify 1.38.0
```

GitHub is currently at:

```text
8d46b73 — Install Livewire
```

Fortify is installed locally but is **not yet committed or pushed**.

### Immediate next steps

When development resumes:

```text
1. Check git status
2. Review composer.json / composer.lock changes
3. Commit Laravel Fortify
4. Push Fortify checkpoint to GitHub
5. Configure Fortify
6. Build authentication views using Livewire/Blade
7. Test registration
8. Test login/logout
9. Verify authenticated user isolation
10. Build Accounts module
```

Do not assume authentication is complete until these steps have been implemented and tested.

---

## 17. Important Note for Future Sessions

When continuing development, first read this file.

Current project state:

```text
Finora
Laravel 12.65.0
PHP 8.2.29
MySQL 8.0.30
Composer 2.4.1
Livewire 4.4.0
Laravel Fortify 1.38.0
```

**Do not upgrade Composer.**

**Do not recreate the Laravel project.**

**Do not assume packages, tools, or configuration have changed unless they are explicitly updated.**

The next immediate task is:

> **Commit and push the locally installed Laravel Fortify dependency, then configure authentication.**
