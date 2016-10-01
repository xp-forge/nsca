<?php namespace org\nagios\unittest;

use org\nagios\nsca\NscaClient;
use org\nagios\nsca\NscaMessage;
use org\nagios\nsca\NscaProtocol;

/**
 * TestCase
 */
class NscaClientTest extends \unittest\TestCase {

  #[@test]
  public function can_create_with_host() {
    $client= new NscaClient('nagios.xp-framework.net');
  }

  #[@test]
  public function can_create_with_host_and_port() {
    $client= new NscaClient('nagios.xp-framework.net', 5667);
  }

  #[@test]
  public function can_create_with_host_port_and_version() {
    $client= new NscaClient('nagios.xp-framework.net', 5667,  NscaProtocol::VERSION_3);
  }

  #[@test]
  public function can_create_with_host_port_and_version_and_crypt() {
    $client= new NscaClient('nagios.xp-framework.net', 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR);
  }

  #[@test]
  public function encrypt() {
    $client= new NscaClient('nagios.xp-framework.net', 5667, NscaProtocol::VERSION_3, NscaProtocol::CRYPT_XOR);
    $client->setTimestamp(base64_decode('S4/Vfw=='));
    $client->setXorKey(base64_decode(
      'enBVWg+sbQJRHBp4YmoAd14qYPF1EwahKFmzQGwwfOah0UGxfq6zz8vNSC03SKW'.
      'WcwaI6BqOikPnPoNTbv86ENF7wVAqdSD1QmgjerHJESTPmQ3qKJctD9WxY0SwnV'.
      'SCGRbTQ4vzOc5cXEkNJlsy9vU/4B3XDi2tv5Dxby5G8kg='
    ));
    $message= new NscaMessage(
      'client.xp-framework.net',
      'testcase',
      NscaProtocol::OK,
      'Test message'
    );
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