<?php

class DatagramServer extends DatagramSocket
{
    public function __construct(LoopInterface $loop, $port, $host='127.0.0.1')
    {
        $address = $host;
        if (strpos($host, ':') !== false) {
            // enclose IPv6 address in square brackets
            $address = '[' . $host . ']';
        }
        $address .= $port;
        
        $socket = stream_socket_server("udp://" . $address, $errno, $errstr, STREAM_SERVER_BIND);
        if (!$socket) {
            die("$errstr ($errno)");
        }
        
        parent::__construct($socket, $address);
        $this->resume();
    }
    
    public function broadcast($message, $port)
    {
        // TODO: no way to set SO_BROADCAST option?
        $address = '255.255.255.255:' . $port;
        stream_socket_sendto($this->socket, $message, 0, $address);
    }
}