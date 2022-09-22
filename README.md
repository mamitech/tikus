# mamitech/tikus

Add Tikus to report your errors to remote error reporting systems such as Bugsnag and Sentry. 

This library supports PHP 7.4+.

## Installation

Merge this into your composer.json

```json
  ...
  "require": {
    "mamitech/tikus": "^1.0"
  }
  ...
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/mamitech/tikus.git"
    }
  ],
  ...
```

Run the command below:
```bash
composer update mamikos/tikus
```

Register `tikus` service provider in providers array in `config/app.php` before your `AppServiceProvider::class`:

```php
'providers' => [
    // ...
    Mamikos\Tikus\Facades\TikusFacade::class,
    // ...
],
```

Register an alias in `config/app.php`:

```php
'aliases' => [
    // ...
    'Tikus' => Mamikos\Tikus\Facades\TikusFacade::class,
],
```

Put this code in `report` method of `app/Exceptions/Handler.php`

```php
use Tikus;

...

public function report(Exception $exception)
{
    if ($this->shouldReport($exception)) {
        Tikus::reportException($exception);
    }
    parent::report($exception);
}
```

To use the configured Bugsnag client, import an alias each time:

```php
use Tikus;

Tikus::reportException($e);
```

## Basic configuration

Configure your Bugsnag or Sentry keys in your `.env` file:

```
BUGSNAG_API_KEY=your-api-key-here

SENTRY_ENVIRONMENT="${APP_ENV}"
SENTRY_LARAVEL_DSN=your-sentry-dsn
```

# Methods

## reportException(Throwable $throwable, Array $metadata = [])
- throwable: Any Throwable, Any Exception
- metadata: metadata in array

### Usage

```php
use Tikus;
...
catch (Exception $e)
{
  Tikus::reportException($e);
}
```

```php
Tikus::reportException(new Exception('Data not found'), [
  'data_id': $data->id
]);
```

## reportError($name, $message, Array $metadata = [])
- name: error type
- message: error message
- metadata: metadata in array

### Usage

```php
use Tikus;

Tikus::reportError('Info', 'Data is expired');

Tikus::reportError('Info', 'Data is expired', ['expired_at': '2022-07-01 12:59:00']);

// supports nested array
Tikus::reportError('Info', 'My wishlist is', [
  'wishlist': [
    'game': 'overwatch 2',
    'movie': 'topgun: maverick'
  ]
]);
```
