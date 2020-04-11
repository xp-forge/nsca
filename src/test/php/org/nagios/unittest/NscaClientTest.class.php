<?php namespace org\nagios\unittest;

use org\nagios\nsca\{NscaClient, NscaMessage, NscaProtocol};

class NscaClientTest extends \unittest\TestCase {
  const NAGIOS = 'nagios.example.com';

  #[@test]
  public function can_create_with_host() {
    new NscaClient(self::NAGIOS);
  }

  #[@test]
  public function can_create_with_host_and_port() {
    new NscaClient(self::NAGIOS, 5667);
  }

  #[@test]
  public function can_create_with_host_port_and_version() {
    new NscaClient(self::NAGIOS, 5667,  NscaProtocol::VERSION_3);
  }

  #[@test]
  public function can_create_with_host_port_and_version_and_crypt() {
    new NscaClient(self::NAGIOS, 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR);
  }

  #[@test]
  public function version() {
    $this->assertEquals(NscaProtocol::VERSION_3, (new NscaClient(self::NAGIOS, 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR))->getVersion());
  }

  #[@test]
  public function version_can_be_modified() {
    $fixture= new NscaClient(self::NAGIOS);
    $fixture->setVersion(NscaProtocol::VERSION_2);
    $this->assertEquals(NscaProtocol::VERSION_2, $fixture->getVersion());
  }

  #[@test]
  public function version_defaults_to_3() {
    $this->assertEquals(NscaProtocol::VERSION_3, (new NscaClient(self::NAGIOS))->getVersion());
  }

  #[@test]
  public function crypt_method() {
    $this->assertEquals(NscaProtocol::CRYPT_XOR, (new NscaClient(self::NAGIOS, 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR))->getCryptMethod());
  }

  #[@test]
  public function crypt_method_can_be_modified() {
    $fixture= new NscaClient(self::NAGIOS);
    $fixture->setCryptMethod(NscaProtocol::CRYPT_NONE);
    $this->assertEquals(NscaProtocol::CRYPT_NONE, $fixture->getCryptMethod());
  }

  #[@test]
  public function crypt_method_defaults_to_xor() {
    $this->assertEquals(NscaProtocol::CRYPT_XOR, (new NscaClient(self::NAGIOS))->getCryptMethod());
  }

  #[@test]
  public function encrypt() {
    $client= new NscaClient(self::NAGIOS, 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR);
    $client->setTimestamp(base64_decode('S4/Vfw=='));
    $client->setXorKey(base64_decode(
      'enBVWg+sbQJRHBp4YmoAd14qYPF1EwahKFmzQGwwfOah0UGxfq6zz8vNSC03SKW'.
      'WcwaI6BqOikPnPoNTbv86ENF7wVAqdSD1QmgjerHJESTPmQ3qKJctD9WxY0SwnV'.
      'SCGRbTQ4vzOc5cXEkNJlsy9vU/4B3XDi2tv5Dxby5G8kg='
    ));
    $message= new NscaMessage('client.xp-framework.net', 'testcase', NscaProtocol::OK, 'Test message');

    $this->assertEquals(
      'enNVWqUY7wkak88HYmpjGzdPDoVba3aMTivSLQlHE5TK/y/UCq6zz8vNSC03SKW'.
      'WcwaI6BqOikPnPoNTbv86ENF7wVAqdSD1QmgjerHJZUG87W6LW/ItD9WxY0SwnV'.
      'SCGRbTQ4vzOc5cXEkNJlsy9vU/4B3XDi2tv5Dxby5G8kh6cFVaD6xtAlEcGnhia'.
      'gB3Xipg8XUTBqEoWbNAbDB85qHRQbF+rrPPy81ILTdIpZZzBojoGo6KQ+c+g1Nu'.
      '/zoQ0XvBUCp1IPVCaCN6sclFQbztLYdN5F5ustRjRLCdVIIZFtNDi/M5zlxcSQ0'.
      'mWzL29T/gHdcOLa2/kPFvLkbySHpwVVoPrG0CURwaeGJqAHdeKmDxdRMGoShZs0'.
      'BsMHzmodFBsX6us8/LzUgtN0illnMGiOgajopD5z6DU27/OhDRe8FQKnUg9UJoI'.
      '3qxyREkz5kN6iiXLQ/VsWNEsJ1UghkW00OL8znOXFxJDSZbMvb1P+Ad1w4trb+Q'.
      '8W8uRvJIenBVWg+sbQJRHBp4YmoAd14qYPF1EwahKFmzQGwwfOah0UGxfq6zz8v'.
      'NSC03SKWWcwaI6BqOikPnPoNTbv86ENF7wVAqdSD1QmgjerHJESTPmQ3qKJctD9'.
      'WxY0SwnVSCGRbTQ4vzOc5cXEkNJlsy9vU/4B3XDi2tv5Dxby5G8kh6cFVaD6xtA'.
      'lEcGnhiagB3Xipg8XUTBqEoWbNAbDB85qHRQbF+rrPPy81ILTdIpZZzBojoGo6K'.
      'Q+c+g1Nu/zoQ0XvBUCp1IPVCaCN6sckRJM+ZDeooly0P1bFjRLCdVIIZFtNDi/M'.
      '5zlxcSQ0mWzL29T/gHdcOLa2/kPFvLkbySHpwVVoPrG0CURwaeGJqAHdeKmDxdR'.
      'MGoShZs0BsMHzmodFBsX6us8/LzUgtN0illnMGiOgajopD5z6DU27/OhDRe8FQK'.
      'nUg9UJoI3qxyREk',
      base64_encode($client->prepare($message))
    );
  }
}