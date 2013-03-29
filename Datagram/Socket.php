<?php

namespace Datagram;

use React\EventLoop\LoopInterface;
use Evenement\EventEmitter;

class Socket extends EventEmitter
{
    protected $loop;
    protected $socket;
    protected $address;

    public function __construct(LoopInterface $loop, $socket, $address)
    {
        $this->loop = $loop;
        $this->socket = $socket;
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPort()
    {
        return (int)substr($this->address, strrpos($this->address, ':') + 1);
    }

    public function getHost()
    {
        return trim(substr($this->address, 0, strrpos($this->address, ':')), '[]');
    }

    public function send($data)
    {
        stream_socket_sendto($this->socket, $data, 0, $this->address);
    }

    public function __toString()
    {
        return $this->address . ' (' . $this->socket . ')';
    }
}
