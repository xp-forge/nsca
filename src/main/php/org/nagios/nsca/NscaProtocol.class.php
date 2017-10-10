<?php namespace org\nagios\nsca;

/**
 * NSCA Protocol constants
 *
 * @test  xp://org.nagios.unittest.NscaProtocolTest
 */
abstract class NscaProtocol {
  const VERSION_2   = 2;
  const VERSION_3   = 3;

  const CRYPT_NONE = 0x0000;
  const CRYPT_XOR  = 0x0001;

  const OK         = 0x0000;
  const WARN       = 0x0001;
  const ERROR      = 0x0002;
  const UNKNOWN    = 0x0003;

  /**
   * Retrieve a status' name
   *
   * @param   int $status
   * @return  string
   */
  public static function statusName($status) {
    static $map= [
      self::OK      => 'NSCA_OK',
      self::WARN    => 'NSCA_WARN',
      self::ERROR   => 'NSCA_ERROR',
      self::UNKNOWN => 'NSCA_UNKNOWN'
    ];
    return $map[$status];
  }
}