# Accompanist
A simple PHP API for generating composer files

## Example

```php
use Accompanist\Accompanist;

$accompanist = new Accompanist('Sample Composer File');

$accompanist->addRequire('monolog/monolog');
$accompanist->addRequire('guzzlehttp/guzzle', '^6.3');

return $accompanist->generateJSON();
```