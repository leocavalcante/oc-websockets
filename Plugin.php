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

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'WebSockets',
            'description' => 'Provides some WebSockets features.',
            'author'      => 'LeoCavalcante',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'LeoCavalcante\WebSockets\Components\WebSocket' => 'websocket',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'leocavalcante.websockets.some_permission' => [
                'tab' => 'WebSockets',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'websockets' => [
                'label'       => 'WebSockets',
                'url'         => Backend::url('leocavalcante/websockets/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['leocavalcante.websockets.*'],
                'order'       => 500,
            ],
        ];
    }

}
