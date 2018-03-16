# Accompanist
A simple PHP API for generating composer files

## Examples

### Basic

```php
use Accompanist\Accompanist;

$accompanist = new Accompanist('Sample Composer File');

$accompanist->addRequire('monolog/monolog');
$accompanist->addRequire('guzzlehttp/guzzle', '^6.3');

$composerJSONString = $accompanist->generateJSON();
// or
$accompanist->writeToFile('output/composer.json');
```

### Load from existing

```php

use Accompanist\Accompanist;

$accompanist = new Accompanist('Imported Composer File');

$accompanist->loadFromFile('import/composer.json');
```