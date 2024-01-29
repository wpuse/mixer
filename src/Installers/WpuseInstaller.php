<?php

namespace Wpuse\Mixer\Installers;

class WpuseInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected array $locations = [
        'plugin'    => 'wp-content/plugins/{$name}/',
        'theme'     => 'wp-content/themes/{$name}/',
        'muplugin'  => 'wp-content/mu-plugins/{$name}/',
        'assist'    =>  '{$name}/',
        'suite'    =>  'suite/{$name}/',
    ];
}
