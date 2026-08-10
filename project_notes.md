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

## 4. Planned Technology Stack

### Backend

- Laravel 12
- PHP 8.2

### Database

- MySQL 8.0

### Frontend

- Laravel Blade
- Livewire
- Tailwind CSS
- JavaScript / Alpine.js where appropriate

### Development

- Laragon
- VS Code
- Chrome
- Node.js / npm for frontend tooling

We are intentionally avoiding a separate React frontend and separate API backend for the initial version.

---

## 5. Planned Application Structure

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

## 6. Planned Database

Initial tables:

```text
users
accounts
categories
transactions
```

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

We plan to use an opening balance plus transactions to determine the current balance rather than making the current balance a separate source of truth.

Conceptually:

```text
Opening Balance
+ Income
- Expenses
+ Transfers In
- Transfers Out
= Current Balance
```

---

## 8. Transaction Concept

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

Transfers should not be counted as expenses.

A transfer between accounts will eventually be represented by two linked transaction records:

```text
Maybank
- RM1,000

        ↓

Savings
+ RM1,000
```

Both records share a transfer identifier.

---

## 9. Planned Dashboard

The initial dashboard should provide:

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

## 10. Development Principles

1. Keep the application simple initially.
2. Do not install unnecessary software.
3. Do not modify the existing development environment without a reason.
4. Financial calculations must have a clear source of truth.
5. Financial records should be traceable.
6. User financial data must be isolated from other users.
7. Build the MVP before adding advanced features.
8. Prefer maintainability over unnecessary technical complexity.

---

## 11. Current Progress

### Completed

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

### Current checkpoint

**STOPPED HERE**

The next task is:

> Configure the MySQL database for Finora.

Planned next steps:

```text
1. Start MySQL in Laragon
2. Create the Finora database
3. Configure Laravel .env
4. Test Laravel ↔ MySQL connection
5. Create initial migrations
6. Design database relationships
7. Implement authentication
8. Build accounts
9. Build transactions
10. Build dashboard
```

---

## 12. Important Note for Future Sessions

When continuing development, first read this file.

Current project state:

```text
Finora
Laravel 12.65.0
PHP 8.2.29
MySQL 8.0.30
Composer 2.4.1
```

Do not assume packages, tools, or configuration have changed unless they are explicitly updated.

**Next immediate task: MySQL database setup.**
