<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TranslateAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sterter:translate-attr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this file will loop on language files and append trans attribute to langa file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        

        return 0;
    }
}
