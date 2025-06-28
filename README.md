# waitlist

## Running Tests

### Local PHPUnit
1. Install dependencies:
   ```bash
   composer install
   ```
2. Run tests:
   ```bash
   ./vendor/bin/phpunit
   ```

### GitHub Actions CI
- Tests run automatically on every push to `main` via `.github/workflows/phpunit.yml`.

## Example Test File
See `tests/WaitlistControllerTest.php` for sample feature tests.