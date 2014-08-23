<?php

namespace ComposerExample;

use ConsoleKit\Command;
use ConsoleKit\Colors;

class HelloCommand extends Command
{
    public function execute(array $args, array $options = array())
    {
        $this->writeln('Hello green World!', Colors::GREEN);
    }
}

