NSCA
====

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-forge/nsca.svg)](http://travis-ci.org/xp-forge/nsca)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_4plus.png)](http://php.net/)
[![Required HHVM 3.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/hhvm-3_4plus.png)](http://hhvm.com/)
[![Latest Stable Version](https://poser.pugx.org/xp-forge/nsca/version.png)](https://packagist.org/packages/xp-forge/nsca)


NSCA (Nagios Service Check Acceptor) Client

Example
-------

```php
use org\nagios\nsca\NscaClient;
use org\nagios\nsca\NscaMessage;

$c= new NscaClient('nagios.example.com');
$c->connect();

$c->send(new NscaMessage(
  'soap1.example.com', 
  'queue_check', 
  NSCA_OK, 
  'Up and running'
));
$c->send(new NscaMessage(
  'soap1.example.com', 
  'queue_check', 
  NSCA_ERROR, 
  'No answer on port 80 after 2 seconds'
));

$c->close();
```
