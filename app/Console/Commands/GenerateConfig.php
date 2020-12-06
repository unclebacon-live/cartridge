<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class GenerateConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartridge:make:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function array_undot($dottedArray) {
        $array = array();
        foreach ($dottedArray as $key => $value) {
            Arr::set($array, $key, $value);
        }
        return $array;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Regenerating config.json');

        $config = $this->array_undot(config('cartridge'));
        
        file_put_contents(base_path('config.json'), json_encode($config, JSON_PRETTY_PRINT));

        return 0;
    }
}
