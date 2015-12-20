<?php namespace org\nagios\unittest;

use org\nagios\nsca\NscaProtocol;

class NscaProtocolTest extends \unittest\TestCase {

  #[@test]
  public function ok() {
    $this->assertEquals('NSCA_OK', NscaProtocol::statusName(NscaProtocol::OK));
  }

  #[@test]
  public function warn() {
    $this->assertEquals('NSCA_WARN', NscaProtocol::statusName(NscaProtocol::WARN));
  }

  #[@test]
  public function error() {
    $this->assertEquals('NSCA_ERROR', NscaProtocol::statusName(NscaProtocol::ERROR));
  }

  #[@test]
  public function unknown() {
    $this->assertEquals('NSCA_UNKNOWN', NscaProtocol::statusName(NscaProtocol::UNKNOWN));
  }
}