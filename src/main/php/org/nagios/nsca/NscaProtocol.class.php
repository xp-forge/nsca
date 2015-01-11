<?php namespace org\nagios\nsca;

/**
 * NSCA Protocol constants
 */
abstract class NscaProtocol extends \lang\Object {
  const VERSION_2 = 2;  
  const VERSION_3 = 3;

  const CRYPT_NONE = 0x0000;
  const CRYPT_XOR  = 0x0001;
}