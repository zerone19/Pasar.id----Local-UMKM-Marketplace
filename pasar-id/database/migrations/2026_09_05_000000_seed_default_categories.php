# Docker Debugging — Tips & Pitfalls

## Build Context Errors

**Problem:** `failed to solve: invalid file request <path>` during `docker build`

**Root cause:** Docker build context includes symlinks that point to paths not valid in the build environment.

**Laravel-specific example:** `public/storage` symlink → `/var/www/html/storage/app/public` (absolute path valid only inside container).

**Fix:** Remove symlinks before build — `rm public/storage`. Use `php artisan storage:link` *after* container starts, or run a post-build entrypoint script.

## Volume Mount Issues

**Problem:** Files created in container not visible on host, or vice versa.

**Root cause:** Incorrect volume mapping in docker-compose.yml, or permission mismatch (host user vs container user).

**Fix:** Verify `volumes:` section maps the right host path. Use `user: "${UID:-1000}:${GID:-1000}"` in compose for consistency.

## Database State Verification

Always verify data persistence after migration:
```bash
docker exec <db-container> <db-client> -e "SELECT COUNT(*) FROM <table>;"
```

Don't assume migrations ran correctly — check actual DB state.

## Asset Accessibility Verification

Verify all static assets are reachable via HTTP status check:
```bash
curl -s -o /dev/null -w "%{http_code}" http://localhost:<port>/path/to/asset
```

Batch-check multiple assets in a loop — catches broken references faster than manual browsing.

## Container Lifecycle Gotchas

- `docker compose up --build` builds images + starts containers
- `docker compose up -d` starts existing images without rebuild
- After changing code that needs rebuild: `docker compose up -d --build`
- Container logs: `docker logs <container-name>` or `docker compose logs --tail=50`