<?php namespace LeoCavalcante\WebSockets;

use Backend;
use System\Classes\PluginBase;

/**
 * WebSockets Plugin Information File
 */
class Plugin extends PluginBase
{
    public function register()
    {
        $this->registerConsoleCommand('websockets.run', 'LeoCavalcante\WebSockets\Console\RunCommand');
    }

    public function pluginDetails()
    {
        return [
            'name'        => 'WebSockets',
            'description' => 'Provides some WebSockets features.',
            'author'      => 'LeoCavalcante',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'LeoCavalcante\WebSockets\Components\WebSocket' => 'websocket',
        ];
    }
}
