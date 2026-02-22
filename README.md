# Mini CMS

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red?logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://www.php.net/)
[![Build Status](https://img.shields.io/github/actions/workflow/status/<your-username>/<repo>/laravel.yml?branch=master&label=build)](https://github.com/<your-username>/<repo>/actions)
[![Test Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen)](#)
[![License](https://img.shields.io/badge/license-MIT-blue)](LICENSE)

A modular **Mini CMS** built with Laravel, featuring multi-guard roles, policy-based authorization, and a state-driven post workflow.

---

## 📐 Architecture Diagram

```mermaid
flowchart TD
    A[HTTP Requests] --> B[Controllers]
    B --> C[Services]
    C --> D[Policies]
    C --> E[Domain Exceptions]
    C --> F[Database / Models]
    B --> G[Form Requests / Validation]
    B --> H[Views / Blade Templates]

--------------------------------------------------------------------------
🎯 Design Principles

    Thin Controllers, service-driven business logic

    Policy-based authorization

    Domain-level exceptions

    Multi-guard support (admin, web)

    Status-based Post Workflow (draft → review → published)

    Feature-test coverage, no mocking business logic

--------------------------------------------------------------------------
🔐 Roles & Permissions

    Multi-guard roles (admin, web)

    Guard selection when creating roles

    Dynamic permission loading via AJAX

    Deletion protection if users exist for a role

    Key Rules

| Action           |    Admin    |    Editor   |               Author              | User |
| ---------------- | :---------: | :---------: | :-------------------------------: | :--: |
| Create Post      |      ✅      |      ✅      |                 ✅                 |   ❌  |
| Update Post      |     Any     |     Any     |                Own                |   ❌  |
| Delete Post      |     Any     |     Any     | Own (published cannot be deleted) |   ❌  |
| Workflow publish | Any (Admin) | Only review |                 ❌                 |   ❌  |

--------------------------------------------------------------------------
📝 Post Workflow

    States: draft → review → published

    Services: PostService + PostWorkflowService

    Policies: role-based transitions

    Tests: feature tests covering all transitions and edge cases

--------------------------------------------------------------------------
🧪 Testing

    Feature tests only

    Covers: workflow transitions, authorization, edge cases

    DB state always asserted (assertDatabaseHas / assertDatabaseMissing)

    Uses RefreshDatabase trait

--------------------------------------------------------------------------
📦 Current Status

    Stage 1 complete: Core CMS + Role & Post workflow

    Guard-aware role creation implemented

    Policies fully enforced

    Feature-test coverage complete

    Published column removed, workflow-driven posts

--------------------------------------------------------------------------
🔜 Next Steps

    Event & Notification Layer (Stage 2)

    Editorial workflow with rejection & review notes

    Versioning & audit logs

    Read Models & Query Layer refactor

    Admin UX improvements (bulk actions, search, filter)

--------------------------------------------------------------------------
🗺 Development Roadmap

| Stage | Focus                       | Status     |
| ----- | --------------------------- | ---------- |
| 1     | Core CMS + Workflow         | ✅ Done     |
| 2     | Events & Notifications      | ⚪ Planned  |
| 3     | Editorial Workflow          | ⚪ Planned  |
| 4     | Versioning & Audit Logs     | ⚪ Planned  |
| 5     | Query Layer & Read Models   | ⚪ Planned  |
| 6     | Admin Search & Bulk Actions | ⚪ Planned  |
| 7     | Testing Hardening           | ⚪ Planned  |
| 8     | Infrastructure & Production | ⚪ Planned  |
| 9     | API Layer                   | ⚪ Optional |
| 10    | Multi-tenant CMS            | ⚪ Optional |

--------------------------------------------------------------------------
⚙️ Installation

    git clone <repo>
    cd <repo>
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    php artisan serve

    Run tests:

    php artisan test

--------------------------------------------------------------------------
🧠 Philosophy

Build small, clean, and maintainable

Controllers thin, services rich

Tests drive behavior, not implementation

Guard-aware roles from start

🏷 License