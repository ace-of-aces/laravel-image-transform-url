<?php

namespace AceOfAces\LaravelImageTransformUrl\Commands;

use Illuminate\Console\Command;

class LaravelImageTransformUrlCommand extends Command
{
    public $signature = 'laravel-image-transform-url';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
