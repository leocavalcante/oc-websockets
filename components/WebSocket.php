<?php namespace LeoCavalcante\WebSockets\Components;

use Cms\Classes\ComponentBase;

class WebSocket extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'WebSocket Component',
            'description' => 'WebSocket client.'
        ];
    }

    public function defineProperties()
    {
        return [
            'uri' => [
                 'title'             => 'URI',
                 'description'       => 'WebSocket server URI',
                 'default'           => 'ws://localhost:8080/',
                 'type'              => 'string',
                 'validationPattern' => '^ws\:\/\/.*',
                 'validationMessage' => 'Enter a valid WebSocket URI'
            ]
        ];
    }

    public function onRun()
    {
        $props = $this->getProperties();
        $this->addJs('/plugins/leocavalcante/websockets/assets/javascript/websocket.js?'.http_build_query($props));
    }

}
