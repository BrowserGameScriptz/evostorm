<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateTilePopulation extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tile_population';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reproduce tile population';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $affected = DB::update('UPDATE tiles AS gm
LEFT JOIN species s ON s.id=gm.species_id SET gm.species_amount= CEIL((((CAST(s.reproduction AS SIGNED)-CAST(s.death_rate AS SIGNED))/100)* RAND())*(gm.species_amount/2))+gm.species_amount
WHERE gm.species_amount>0;');
    }

}
