<p align="center" style="margin-top: 2rem; margin-bottom: 2rem;"><img src="/art/hotstream-logo.svg" alt="Logo Hotstream" /></p>

<p align="center">
    <a href="https://packagist.org/packages/hotwired/hotstream">
        <img src="https://img.shields.io/packagist/v/hotwired/hotstream" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/hotwired/hotstream">
        <img src="https://img.shields.io/packagist/l/hotwired/hotstream" alt="License">
    </a>
</p>

Hotstream is an application Starter Kit for Laravel. It's heavily inspired by [Laravel Jetstream](https://github.com/laravel/jetstream), but modified to better work as a [Hotwired](https://hotwired.dev/) application.

It comes with [Turbo.js](https://turbo.hotwired.dev/), [Stimulus](https://stimulus.hotwired.dev/), [Importmap Laravel](https://github.com/tonysm/importmap-laravel), and [TailwindCSS Laravel](https://github.com/tonysm/tailwindcss-laravel). And features a Node-less frontend setup.

## Installation

You can install the package via composer:

```bash
composer require hotwired/hotstream
```

You can install Hotstream by running:

```bash
php artisan hostream:install
```

Alternatively, you can opt-in to include Teams:

```bash
php artisan hostream:install --teams
```

Then, migrate:

```bash
php artisan migrate
```

Since we're using [Importmap Laravel](https://github.com/tonysm/importmap-laravel), you'll need to create the symlink to map the JS folder to your `public/` folder by running (remember to run that inside Sail if you're using that):

```bash
php artisan storage:link
```

Next, to finish the [TailwindCSS Laravel](https://github.com/tonysm/tailwindcss-laravel) installation, you'll need to download the Tailwind CLI and compile your assets at least once:

```bash
php artisan tailwindcss:download
php artisan tailwindcss:build
```

Done!

## Documentation

Documentation for Hotstream can be found on the [Hotstream section of the Turbo Laravel website](https://hotstream.turbo-laravel.com).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tony Messias](https://github.com/tonysm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
