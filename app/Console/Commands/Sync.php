<?php

namespace App\Console\Commands;

use App\Models\Variable;
use App\Models\Page;
use Illuminate\Console\Command;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:variables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'syncs local records with remote db';

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
     * @return mixed
     */
    public function handle()
    {
        $this->variables();
    }

    private function variables()
    {
        $this->info('Getting variables...');
        $variables = Variable::all();

        $bar = $this->output->createProgressBar(count($variables));

        \DB::connection('remote')->table('variables')->truncate();
        foreach ($variables as $variable) {
            \DB::connection('remote')->table('variables')->insert($variable->toArray());
            $bar->advance();
        }

        $bar->finish();
    }

}
