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
        global $app;
        $headers = ['method', 'uri', 'uses', 'name', 'middleware'];
        $body = [];
        foreach($app->router->getRoutes() as $route){
            $body[] = [
                $route['method'],
                $route['uri'],
                $route['action']['uses'],
                $route['action']['as'],
                implode(',',$route['action']['middleware'])
                ];
        };
        $this->table($headers,$body);
    }


}