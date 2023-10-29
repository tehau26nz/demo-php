<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

// Add or bind in the container.
$container->bind(
    'Core\Database',
    // Assoc builder function with the previous string.
    function () {
        // Necessary config.
        $config = require base_path('config.php');
        // Pass it to constructor.
        return new Database($config['database']);
    }
);

App::setContainer($container);
