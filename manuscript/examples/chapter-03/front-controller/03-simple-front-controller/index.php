<?php

switch ($_SERVER['REQUEST_URI']) {
    case '/page1':
        echo 'You are viewing page 1';
        break;

    case '/page2':
        echo 'You are viewing page 2';
        break;

    default:
        header('HTTP/1.0 404 Not Found');

        echo '<html>'
            . '<head><title>404 Not Found</title></head>'
            . '<body><h1>404 Not Found</h1></body>'
            . '</html>';
}
