<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CollectionController;

class ShowMethod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:method';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $collectionsController = new CollectionController();

        // dump($collectionsController->collectionMethod());
        // dump($collectionsController->ddMethod());
        // dump($collectionsController->avgMethod());
        // dump($collectionsController->mapWithKeysMethod());
        // dump($collectionsController->usefulMethod());
        dump($collectionsController->macroMethod());
    }
}
