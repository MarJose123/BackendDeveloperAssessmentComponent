<?php

namespace MarJose123\BackendDeveloperAssessmentComponent\Commands;

use Illuminate\Console\Command;

class BackendDeveloperAssessmentComponentCommand extends Command
{
    public $signature = 'backenddeveloperassessmentcomponent';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
