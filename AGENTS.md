# AI Agents Guide for TailAdmin Laravel

This document provides guidance for AI agents working with the TailAdmin Laravel project, including architectural patterns, coding standards, and best practices.

## Phase History

### Phase 1: Role Switching System ✅ COMPLETED

- **Created:** 2026-02-26
- **Status:** COMPLETED
- **Description:** Implemented dual-role switching for users with both teacher and student roles

A dual-role switching system has been implemented for users with both `teacher` and `student` roles.

**What was done:**
- **Topbar Radio Switcher**: `resources/views/components/header/switch-role.blade.php`
  - Only visible when user has both teacher AND student roles
  - Stores active role in session via AJAX (`POST /role/switch`)
  - Persists selection in sessionStorage + server session
  - Auto-reloads page on switch to update sidebar menu

- **Session-Based Role Filtering**: `app/Helpers/MenuHelper.php`
  - `getMenuGroups()` now checks `session('active_role')`
  - Only shows Teacher Menu OR Student Menu based on active role
  - Added `userHasBothRoles()` helper
  - Added `getActiveRole()` helper

- **URL Access Protection**: `app/Http/Middleware/ActiveRoleMiddleware.php`
  - Enforces active role on `/teacher/*` and `/student/*` routes
  - Redirects to appropriate dashboard if user tries to access wrong role's URL
  - Example: If in "Student" mode, accessing `/teacher/quiz` redirects to `/student`

- **New Routes**:
  ```php
  POST /role/switch    # Switch active role (AJAX)
  GET  /role/active    # Get current active role
  ```

**Key Files Modified:**
| File | Change |
|------|--------|
| `app/Http/Controllers/RoleController.php` | NEW - Handles role switching logic |
| `app/Http/Middleware/ActiveRoleMiddleware.php` | NEW - Enforces active role on routes |
| `app/Helpers/MenuHelper.php` | MODIFIED - Filters menu by active role |
| `resources/views/components/header/switch-role.blade.php` | MODIFIED - Added AJAX sync |
| `resources/views/layouts/app-header.blade.php` | MODIFIED - Passes role props to switcher |
| `routes/web.php` | MODIFIED - Added role routes + middleware |
| `bootstrap/app.php` | MODIFIED - Registered `active_role` middleware |

**How it works:**
1. User with both roles sees radio switcher in topbar
2. Switching stores `active_role` in session
3. Sidebar only shows menu for active role
4. Middleware blocks direct URL access to non-active role routes
5. Single-role users see no switcher and access their routes normally

---

## Project Overview

**TailAdmin Laravel** is a modern admin dashboard built with:
- **Laravel 12** (PHP 8.2+)
- **Tailwind CSS v4** with Vite build system
- **Alpine.js** for lightweight interactivity
- **Spatie Laravel Permission** for role-based access control (RBAC)

The application is a multi-role educational management system with:
- **Master**: System overview and profile management
- **Admin**: User/role/permission management and system tools
- **Teacher**: Class management, quizzes, questions, reports
- **Student**: Class access, certificates, reports

## Architecture Patterns

### 1. Repository Pattern
The project uses the Repository Pattern for data access abstraction:

```
app/Repositories/
├── Contracts/MenuRepositoryInterface.php
├── AdminMenuRepository.php
├── MasterMenuRepository.php
├── TeacherMenuRepository.php
└── StudentMenuRepository.php
```

Each repository implements `MenuRepositoryInterface` and provides role-specific page mappings via `getPageMap()`.

### 2. Service Pattern
Business logic is encapsulated in service classes:

```
app/Services/
├── Contracts/MenuServiceInterface.php
├── AdminMenuService.php
├── MasterMenuService.php
├── TeacherMenuService.php
└── StudentMenuService.php
```

Services use constructor injection for repositories and implement `MenuServiceInterface` with methods:
- `all()`: Returns all available pages
- `getByKey(string $key)`: Returns specific page by key

### 3. Dependency Injection
Repository binding is configured in `AppServiceProvider.php` using Laravel's contextual binding:

```php
$this->app->when(MasterMenuService::class)
    ->needs(MenuRepositoryInterface::class)
    ->give(MasterMenuRepository::class);
```

### 4. Role-Based Access Control (RBAC)
Permissions are enforced using:
- **Middleware**: `role:admin`, `role_or_permission:teacher|admin`, `active_role:teacher|student`
- **Route-level**: `->middleware('can:permission.name')`
- **Authorization gates**: Spatie Permission package

**Global Permissions**: The `master.*` permission namespace is mandatory for all roles. Any permission starting with `master.` (e.g., `master.dashboard`, `master.information`) is automatically granted to all users regardless of their assigned role.

**Active Role Middleware**: For users with dual roles (teacher + student), the `active_role` middleware enforces the currently selected role:
```php
Route::prefix('teacher')->middleware(['role_or_permission:teacher|admin', 'active_role:teacher'])
```
This prevents users from accessing teacher routes when in "Student" mode, even if they have both roles.

### 5. View Components
Reusable UI components are organized under:

```
app/View/Components/
├── form/
│   ├── select/MultipleSelect.php
│   ├── input/Radio.php
│   ├── DatePicker.php
│   └── FormElements/
│       ├── InputGroup.php
│       ├── SelectInputs.php
│       ├── CheckboxComponent.php
│       └── ...
└── ui/
    ├── Avatar.php
    └── Badge.php
```

## File Organization Conventions

### Controllers
- One controller per role/context: `AdminMenuController`, `TeacherMenuController`, etc.
- Use `show()` method with `page` parameter for dynamic page rendering
- Keep controllers thin; delegate to services

### Routes
- Group routes by role with appropriate middleware
- Use route prefixes and names consistently
- Apply permission middleware at route level

```php
Route::prefix('teacher')->name('teacher.')
    ->middleware('role_or_permission:teacher|admin')
    ->group(function () {
        Route::get('/my-class', [TeacherMenuController::class, 'show'])
            ->defaults('page', 'my-class')
            ->name('my-class')
            ->middleware('can:teacher.my-class.view');
    });
```

### Blade Views
- Organize views by role/feature
- Use kebab-case for view files and folders
- Leverage View Components for reusable UI elements

## Agent Task Guidelines

### When Adding New Features

1. **Analyze existing patterns**: Follow the established Repository + Service pattern
2. **Create interface first**: Define contracts before implementations
3. **Bind in AppServiceProvider**: Add contextual bindings for new service/repository pairs
4. **Add permissions**: Update `RolesAndPermissionsSeeder` if new permissions needed
5. **Follow naming conventions**: Use PascalCase for classes, camelCase for methods

### When Modifying Menu/Navigation

1. Update the appropriate Repository's `getPageMap()` method
2. The mapping format is: `'route-name' => 'Display Title'`
3. Ensure corresponding routes exist in `web.php`
4. Add appropriate permission middleware to routes

### When Working with Permissions

Permission naming convention:
- `{role}.{resource}.{action}` (e.g., `teacher.my-class.view`, `admin.user.create`)

**Global Permissions (Master)**:
- All `master.*` permissions are automatically granted to every user
- Use `master.dashboard` for dashboard access, `master.information` for profile pages
- Do not create role-specific versions of these permissions

Available guard names: `web` (default)

Roles: `master`, `admin`, `teacher`, `student`

### When Adding Routes

1. Place in appropriate middleware group (guest/auth)
2. Apply role middleware based on intended users
3. Add permission middleware for fine-grained access
4. Use consistent naming: `{role}.{action}` or `{role}.{resource}.{action}`

### Frontend Considerations

- Uses Tailwind CSS v4 with Vite
- Alpine.js for JavaScript interactions
- Components should be Blade-based with View Component classes when needed
- Flatpickr for date picking, ApexCharts for charts

## Testing Standards

- Uses **Pest PHP** for testing (configured in `phpunit.xml`)
- Tests located in `tests/Feature/` and `tests/Unit/`
- Run tests with: `composer run test` or `php artisan test`

## Common Commands

```bash
# Development
composer run dev          # Start all dev services
npm run dev              # Start Vite dev server only

# Code generation
php artisan make:controller NameController
php artisan make:model Name -m
php artisan make:migration create_table_name

# Database
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Caching (production)
php artisan optimize
php artisan config:cache
php artisan route:cache
```

## Critical Files Reference

| File | Purpose |
|------|---------|
| `app/Providers/AppServiceProvider.php` | Repository bindings |
| `database/seeders/RolesAndPermissionsSeeder.php` | RBAC configuration |
| `routes/web.php` | All web routes |
| `app/Helpers/MenuHelper.php` | Sidebar/menu utilities + active role filtering |
| `app/Http/Controllers/RoleController.php` | Role switching logic |
| `app/Http/Middleware/ActiveRoleMiddleware.php` | Active role enforcement |
| `resources/views/components/header/switch-role.blade.php` | Role switcher UI |

## Security Reminders

- Always validate user input using Form Requests
- Use authorization gates/policies for data access
- Apply appropriate middleware to all routes
- Sanitize output in Blade templates (use `{{ }}` by default)
- Never expose sensitive data in queries or logs

## Code Style

- Follow Laravel Pint standards (configured)
- PHP 8.2+ features: constructor property promotion, readonly properties
- Use type hints and return types
- Import all classes (no inline FQN)
- Use `__DIR__` or `base_path()` for paths, not relative paths

## Forbidden Patterns

- Controllers MUST NOT access Models directly
- Business logic MUST NOT exist in Blade
- Do not query database inside View Components
- Always use Service layer

## Architecture Decisions

- Session used for active_role to avoid DB write on switch
- Alpine.js preferred over Livewire for UI micro-interaction
- Menu generated dynamically via Repository pattern

## Example Tasks

### Adding Teacher Page

1. Add page mapping in TeacherMenuRepository
2. Create route in teacher group
3. Add permission teacher.xxx.view
4. Create blade view
5. Use TeacherMenuService

---

## How to Update This Document

When making new changes, update the **Phase History** section at the top:

1. **Add new phase** at the top of Phase History (newest first):
   ```markdown
   ### Phase X: [Feature Name] [STATUS]

   - **Created:** YYYY-MM-DD
   - **Status:** IN_PROGRESS / COMPLETED / PENDING
   - **Description:** Brief description of what is being worked on
   ```

2. **Update previous phase** status if needed (e.g., mark as COMPLETED)

3. **Add detailed notes** under the phase for:
   - What was done
   - Key files created/modified
   - How it works
   - Any known issues or TODOs

This ensures any agent continuing work tomorrow can quickly understand the project state.
