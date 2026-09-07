# Laravel-Specific Debugging Notes

## Custom Pagination in Laravel 13

### Registering a custom pagination view

The correct method in Laravel 13 (verified):

```php
// AppServiceProvider::boot()
use Illuminate\Pagination\AbstractPaginator;

AbstractPaginator::defaultView('components.pagination');
AbstractPaginator::defaultSimpleView('components.pagination');
```

### Pitfalls

| Error | Cause | Fix |
|-------|-------|-----|
| `Call to undefined method AbstractPaginator::useView()` | Wrong method name for Laravel 13 | Use `defaultView()` not `useView()` |
| Custom pagination still shows default | View cache is stale | `php artisan view:clear` |

## Database Debugging Patterns

### Checking for empty lookup tables

```bash
# categories / lookup tables that drive dropdowns
docker exec <db> mysql -u <user> -p<pass> <db> -e "SELECT COUNT(*) FROM categories;"

# products with broken image references
docker exec <db> mysql -u <user> -p<pass> <db> -e \
  "SELECT id, name, thumbnail FROM products WHERE thumbnail LIKE '%.svg';"
```

### Reassigning assets via migration

When DB stores `.svg` but real files are `.png`:

```php
// In a migration's up()
$productImageMap = [
    'keripik-singkong-pedas' => 'products/keripik-singkong-pedas-5.png',
    ...
];
DB::table('products')->where('slug', 'LIKE', '%keripik-singkong-pedas%')
    ->update(['thumbnail' => $pngPath]);
```

## Blade View Debugging

### Checking what data a view receives

Temporarily add to the Blade template:
```blade
{{ dd(get_defined_vars()) }}
```

### Forcing view re-render

```bash
docker compose exec app php artisan view:clear
docker compose exec app php artisan config:clear
```

## Storage Symlink in Docker

### The build-context problem

`public/storage` symlink targets `/var/www/html/storage/app/public` —
valid inside the container but invalid during `docker build`.

### Two-step fix

1. **Pre-build:** remove the symlink so the build context is clean:
   ```bash
   rm pasar-id/public/storage
   ```
2. **Post-start:** regenerate it inside the container:
   ```bash
   docker compose exec app php artisan storage:link
   ```