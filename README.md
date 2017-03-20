# Php return type checker

Checks which methods are missing a return type hint

## Install

Add 

```
{
    "url": "git@github.com:marcosh/php-return-type-checker.git",
    "type": "git"
}
```

among the repositories of your `composer.json` and then use

```
composer require marcosh/php-return-type-checker
```

## Use

```
php bin/ptc.php check $PATH
```

```
docker run --rm -ti -v "$(pwd):/app" -v "/srv/apps/arval/car-sharing:/src" prooph/php:7.1-cli php bin/ptc.php check /src/domain/src
```
