<?php

$pageName = $_SERVER['REQUEST_URI'];

function show404()
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Not found.';
    exit();
}

if (!preg_match('!/show-details/(.*)$!', $pageName, $parts)) {
    show404();
}

$name = $parts[1];

if ($name !== 'John') {
    show404();
}

echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <title>View Customer</title>
    </head>
    <body>
        <h1>John's Details</h1>
        <p>
            Name: <span class="name">John</span><br>
            Email: <span class="email">john@gmail.com</span>
        </p>
    </body>
</html>
EOT;
