<?php

namespace Khalti\KhaltiLaravel\Commands;

use Illuminate\Console\Command;

class KhaltiLaravelCommand extends Command
{
    public $signature = 'khalti-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
