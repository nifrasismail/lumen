<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MyApiRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mam:api-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of custom api routes.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
            [
                'name',
                'route'
            ],
            [
                ['get_all_products', route('get_all_products')],
                ['get_product_by_id', route('get_product_by_id')]
            ]);
    }
}