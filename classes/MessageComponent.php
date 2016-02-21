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

    public function onMessage(ConnectionInterface $from, $message)
    {
        $event = json_decode($message);

        foreach ($this->peers as $peer) {
            if ($peer == $from && !empty($event->broadcast)) {
                continue;
            }

            $peer->send($message);
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
