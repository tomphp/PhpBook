<?php

namespace ComposerExample;

use ConsoleKit\Console;

class HelloApplication extends Console
{
    public function run()
    {
        $console = new Console();
        $console->addCommand('ComposerExample\\HelloCommand');
        $console->run();
    }
}
