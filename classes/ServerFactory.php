<?php namespace LeoCavalcante\WebSockets\Classes;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerFactory
{
    public static function create($port)
    {
        return IoServer::factory(new HttpServer(new WsServer(new MessageComponent())), $port);
    }
}
