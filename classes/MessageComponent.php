<?php namespace LeoCavalcante\WebSockets\Classes;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MessageComponent implements MessageComponentInterface
{
    protected $peers;

    public function __construct()
    {
        $this->peers = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->peers->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->peers as $peer) {
            $peer->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->peers->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}
