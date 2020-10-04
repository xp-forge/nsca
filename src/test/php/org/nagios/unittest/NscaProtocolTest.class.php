<?php namespace org\nagios\unittest;

use org\nagios\nsca\NscaProtocol;
use unittest\Test;

class NscaProtocolTest extends \unittest\TestCase {

  #[Test]
  public function ok() {
    $this->assertEquals('NSCA_OK', NscaProtocol::statusName(NscaProtocol::OK));
  }

  #[Test]
  public function warn() {
    $this->assertEquals('NSCA_WARN', NscaProtocol::statusName(NscaProtocol::WARN));
  }

  #[Test]
  public function error() {
    $this->assertEquals('NSCA_ERROR', NscaProtocol::statusName(NscaProtocol::ERROR));
  }

  #[Test]
  public function unknown() {
    $this->assertEquals('NSCA_UNKNOWN', NscaProtocol::statusName(NscaProtocol::UNKNOWN));
  }
}