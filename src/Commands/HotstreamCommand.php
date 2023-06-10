<?php

namespace Hotwired\Hotstream\Commands;

use Illuminate\Console\Command;

class HotstreamCommand extends Command
{
    public $signature = 'hotstream';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
