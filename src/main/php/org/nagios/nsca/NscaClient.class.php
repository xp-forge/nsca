<?php namespace org\nagios\nsca;

use peer\Socket;
use security\checksum\CRC32;
use lang\MethodNotImplementedException;
use lang\IllegalStateException;
use lang\IllegalArgumentException;

define('NSCA_VERSION_2',  2);
define('NSCA_VERSION_3',  3);
define('NSCA_CRYPT_NONE', 0x0000);
define('NSCA_CRYPT_XOR',  0x0001);

/**
 * NSCA (Nagios Service Check Acceptor) Client. Send passive checks for Nagios.
 *
 * ```php
 * $c= new NscaClient('nagios.example.com');
 * $c->connect();
 * $c->send(new NscaMessage(
 *   'soap1.example.com', 
 *   'queue_check', 
 *   NSCA_OK, 
 *   'Up and running'
 * ));
 * $c->send(new NscaMessage(
 *   'soap1.example.com', 
 *   'queue_check', 
 *   NSCA_ERROR, 
 *   'No answer on port 80 after 2 seconds'
 * ));
 * $c->close();
 * ```
 *
 * @see   http://www.nagios.org/download/extras.php
 * @see   http://nagios.sourceforge.net/download/cvs/nsca-cvs.tar.gz
 * @see   http://jasonplancaster.com/projects/scripts/send_nsca/send_nsca_pl.source  
 */
class NscaClient extends \lang\Object {
  public
    $sock         = null,
    $version      = 0,
    $cryptmethod  = 0,
    $timeout      = 10;
    
  public
    $_xorkey      = '',
    $_timestamp   = '';

  /**
   * Constructor
   *
   * @param   string $host the host the NSCA server is running on
   * @param   int $port
   * @param   int $version default NSCA_VERSION_3
   * @param   int $cryptmethod default CRYPT_XOR
   */
  public function __construct(
    $host, 
    $port= 5667, 
    $version= NscaProtocol::VERSION_3, 
    $cryptmethod= NscaProtocol::CRYPT_XOR
  ) {
    
    $this->sock= new Socket($host, $port);
    $this->version= $version;
    $this->cryptmethod= $cryptmethod;
  }

  /**
   * Set Version
   *
   * @param   int $version
   */
  public function setVersion($version) {
    $this->version= $version;
  }

  /**
   * Get Version
   *
   * @return  int
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * Set Cryptmethod
   *
   * @param   int $cryptmethod
   */
  public function setCryptmethod($cryptmethod) {
    $this->cryptmethod= $cryptmethod;
  }

  /**
   * Get Cryptmethod
   *
   * @return  int
   */
  public function getCryptmethod() {
    return $this->cryptmethod;
  }

  /**
   * Set read Timeout
   *
   * @param   int $timeout
   */
  public function setTimeout($timeout) {
    $this->timeout= $timeout;
  }

  /**
   * Get Timeout
   *
   * @return  int
   */
  public function getTimeout() {
    return $this->timeout;
  }

  /**
   * Connects to the NSCA server
   *
   * @return  bool
   */
  public function connect() {
    if (!$this->sock->connect()) return false;
    $this->sock->setTimeout($this->getTimeout());

    // Get 128bit xor key and 4bit timestamp
    $this->setXorKey($this->sock->readBinary(0x0080));
    $this->setTimestamp($this->sock->readBinary(0x0004));
    return true;
  }
  
  /**
   * Set timestamp
   *
   * @param   string $key
   * @throws  lang.IllegalArgumentException if length of data is invalid
   */
  public function setTimestamp($key) {
    if (4 !== strlen($key)) {
      throw new IllegalArgumentException('Timestamp must be 4 bytes, exactly; '.strlen($key).' given.');
    }
    $this->_timestamp= $key;
  }

  /**
   * Set XOR key
   *
   * @param   string $key
   * @throws  lang.IllegalArgumentException if length of data is invalid
   */
  public function setXorKey($key) {
    if (128 !== strlen($key)) {
      throw new IllegalArgumentException('Xorkey must be 128 bytes, exactly; '.strlen($key).' given.');
    }
    $this->_xorkey= $key;
  }

  /**
   * Returns a string representation of this object
   *
   * @return  string
   */
  public function toString() {
    static $cryptname= [
      NscaProtocol::CRYPT_NONE => 'NONE',
      NscaProtocol::CRYPT_XOR  => 'XOR'
    ];

    return sprintf(
      "%s@{\n".
      "  [endpoint]    nsca://%s:%d\n".
      "  [version]     %d\n".
      "  [cryptmethod] %d (%s)\n".
      "  [timestamp]   (%d bytes) %s\n".
      "  [xorkey]      (%d bytes) %s\n".
      "}\n",
      nameof($this),
      $this->sock->host,
      $this->sock->port,
      $this->version,
      $this->cryptmethod,
      $cryptname[$this->cryptmethod],
      strlen($this->_timestamp),
      base64_encode($this->_timestamp),
      strlen($this->_xorkey),
      base64_encode($this->_xorkey)
    );
  }
  
  /**
   * Closes the communication socket to the NSCA server
   *
   * @return  bool 
   */
  public function close() {
    return $this->sock->isConnected() ? $this->sock->close() : TRUE;
  }
  
  /**
   * Helper method which packs the message 
   *
   * @param   string $crc
   * @param   org.nagios.nsca.NscaMessage $message
   * @return  string packed data
   */
  public function pack($crc, $message) {
    return pack(
      'nxxNa4na64a128a512xx',
      $this->version,
      $crc,
      $this->_timestamp,
      $message->getStatus(),
      $message->getHost(),
      $message->getService(),
      $message->getInformation()
    );
  }
  
  /**
   * Helper method which encrypts data
   *
   * @param   string $data
   * @return  string encrypted data
   * @throws  lang.MethodNotImplementedException in case the encryption method is not supported
   */
  public function encrypt($data) {
    switch ($this->cryptmethod) {
      case NscaProtocol::CRYPT_NONE:
        return $data;
        
      case NscaProtocol::CRYPT_XOR:
        $len= strlen($data);
        return substr(
          $data ^ (str_repeat($this->_xorkey, intval(($len + 127) / 128))),
          0,
          $len
        );
     
      default:
        throw new MethodNotImplementedException(
          'Encryption method '.$this->cryptmethod.' not supported'
        );
    }
  }

  /**
   * Prepare data to be sent
   *
   * @param   org.nagios.nsca.NscaMessage $message
   * @return  string
   */
  public function prepare(NscaMessage $message) {

    // Calculate CRC32 checksum, then build the final packet with the sig
    // and encrypt it using defined crypt method
    return $this->encrypt($this->pack(CRC32::fromString($this->pack(0, $message))->asInt32(), $message));
  }

  /**
   * Send a NSCA message to the server
   *
   * @param   org.nagios.nsca.NscaMessage $message
   * @return  bool
   * @throws  lang.IllegalStateException
   */
  public function send(NscaMessage $message) {
    if (!$this->sock->isConnected()) {
      throw new IllegalStateException('Not connected');
    }
    
    // Finally, send data to the socket
    return $this->sock->write($this->prepare($message));
  }
}
