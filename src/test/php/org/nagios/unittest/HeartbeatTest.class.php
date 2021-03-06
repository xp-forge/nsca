<?php namespace org\nagios\unittest;

use org\nagios\nsca\Heartbeat;
use unittest\Test;

/**
 * Test heartbeat class
 *
 * @see   xp://org.nagios.nsca.Heartbeat
 */
class HeartbeatTest extends \unittest\TestCase {
  private $fixture;

  /**
   * Creates fixture
   *
   * @return void
   */
  public function setUp() {
    $this->fixture= new Heartbeat();
  }
  
  #[Test]
  public function domain() {
    $this->fixture->setup('nagios://nagios.xp-framework.net:5667/servicename?hostname=client&domain=xp-framework.net');
    $this->assertEquals('client.xp-framework.net', $this->fixture->host);
  }

  #[Test]
  public function domain_with_leading_dot() {
    $this->fixture->setup('nagios://nagios.xp-framework.net:5667/servicename?hostname=client&domain=xp-framework.net');
    $this->assertEquals('client.xp-framework.net', $this->fixture->host);
  }
}