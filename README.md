# Event Calendar

# Installation

### General setup:
```
composer install
npm install

cp .env.example .env
php artisan key:generate
```

### Database setup:
Either `php artisan migrate` or `php artisan migrate --seed`

### Development setup:
```
npm run dev
php artisan serve
```

### Rerunning database migrations and seeder:
```
php artisan migrate:refresh --seed
```

### Add keys for reCAPTCHA:
Create a new reCAPTCHA key pair at https://www.google.com/recaptcha/admin/create

On Development, add the following to your `.env` file:
```
NOCAPTCHA_SITEKEY=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
NOCAPTCHA_SECRET=6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
```

### Icon Caching
```
php artisan icons:cache
```
When adding new icons, clear the cache with `php artisan icons:clear` and run the cache command again.

# Technical documentation

Wysiwg editor: https://github.com/tonysm/rich-text-laravel
Captcha: https://github.com/anhskohbo/no-captcha
Image cropping: https://fengyuanchen.github.io/cropperjs/
Icons: https://github.com/blade-ui-kit/blade-heroicons

# Console Commands
- `php artisan app:add-admin {email}` give a user admin rights
- `php artisan app:remove-admin {email}` remove a user's admin rights
- `php artisan app:list-admins` list all admins
