<?php

use Jenssegers\Blade\Blade;

function view($template, $data = [])
{
    $blade = new Blade(__DIR__ . '/../resources/views', __DIR__ . '/../cache');
    echo $blade->render($template, $data);
}
