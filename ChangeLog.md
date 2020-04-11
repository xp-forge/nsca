NSCA ChangeLog
==============

## ?.?.? / ????-??-??

## 7.0.0 / 2020-04-11

* Implemented xp-framework/rfc#334: Drop PHP 5.6:
  . **Heads up:** Minimum required PHP version now is PHP 7.0.0
  . Rewrote code base, grouping use statements
  (@thekid)

## 6.0.1 / 2020-04-04

* Made compatible with XP 10 - @thekid

## 6.0.0 / 2017-10-10

* **Heads up: Drop PHP 5.5 support!** - @thekid
* Added compatibility with XP9, PHP 7.2 - @thekid
* Dropped dependency on `xp-framework/security` - @thekid

## 5.1.2 / 2017-04-18

* Added compatibility with `xp-framework/networking` 8.x - @thekid

## 5.1.1 / 2016-10-01

* Fixed issue #1: Wrong constant name - @emil-nasso, @thekid

## 5.1.0 / 2016-08-28

* Added forward compatibility with XP 8.0.0 - @thekid

## 5.0.1 / 2016-04-22

* Fixed exception handling in HeartBeat and NscaClient classes - @kiesel

## 5.0.0 / 2016-02-21

* Added version compatibility with XP 7 - @thekid

## 4.0.1 / 2016-01-23

* Fix code to use `nameof()` instead of the deprecated `getClassName()`
  method from lang.Generic. See xp-framework/core#120
  (@thekid)

## 4.0.0 / 2015-12-20

* **Heads up: Dropped PHP 5.4 support**. *Note: As the main source is not
  touched, unofficial PHP 5.4 support is still available though not tested
  with Travis-CI*.

## 3.1.0 / 2015-11-24

* Added class constants OK, WARN, ERROR and UNKNOWN to NscaProtocol. These
  supersede the NSCA_* global constants, which can be considered deprecated
  at the same time.
  (@thekid)

## 3.0.1 / 2015-02-12

* Changed dependency to use XP ~6.0 (instead of dev-master) - @thekid

## 3.0.0 / 2015-01-11

* Heads up: Changed NSCA to depend on XP6 core (@thekid)
* Heads up: Changed defines for encryption and protocol version to class
  constants (@thekid)
* Converted code base to PHP 5.3 namespaces - @thekid

## 2.1.3 / 2010-03-04

* Fix for crc32 and refactoring - @kiesel

## 2.1.2 / 2007-11-24

* Fix for domain names @kiesel

## 2.1.1 / 2007-05-23

* Allow leading dot for domains - @kiesel

## 2.1.0 / 2007-05-16

* Added heartbeat class, NscaClient timeouts - @kiesel

## 2.0.0 / 2010-10-06

* PHP 5 migration - @kiesel 

## 1.0.1 / 2003-12-30

* Added new nameOfStatus() method - @thekid

## 1.0.0 / 2003-09-10

* Initial release - @thekid
