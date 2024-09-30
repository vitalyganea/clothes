<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cities = [
            ['name' => 'Chișinău'],
            ['name' => 'Tiraspol'],
            ['name' => 'Bălți'],
            ['name' => 'Bender (Tighina)'],
            ['name' => 'Cahul'],
            ['name' => 'Ungheni'],
            ['name' => 'Soroca'],
            ['name' => 'Orhei'],
            ['name' => 'Dubăsari'],
            ['name' => 'Comrat'],
            ['name' => 'Căușeni'],
            ['name' => 'Edineț'],
            ['name' => 'Cimișlia'],
            ['name' => 'Rîbnița'],
            ['name' => 'Drochia'],
            ['name' => 'Strășeni'],
            ['name' => 'Fălești'],
            ['name' => 'Hîncești'],
            ['name' => 'Ialoveni'],
            ['name' => 'Leova'],
            ['name' => 'Nisporeni'],
            ['name' => 'Rezina'],
            ['name' => 'Ștefan Vodă'],
            ['name' => 'Sîngerei'],
            ['name' => 'Telenești'],
            ['name' => 'Anenii Noi'],
            ['name' => 'Basarabeasca'],
            ['name' => 'Briceni'],
            ['name' => 'Cantemir'],
            ['name' => 'Criuleni'],
            ['name' => 'Dondușeni'],
            ['name' => 'Florești'],
            ['name' => 'Glodeni'],
            ['name' => 'Ocnița'],
            ['name' => 'Rîșcani'],
            ['name' => 'Șoldănești'],
            ['name' => 'Taraclia'],
            ['name' => 'Vulcănești'],
            ['name' => 'Grigoriopol'],
            ['name' => 'Camenca'],
            ['name' => 'Slobozia'],
            ['name' => 'Cornești'],
            ['name' => 'Frunză'],
            ['name' => 'Vadul lui Vodă'],
            ['name' => 'Vatra'],
            ['name' => 'Codru'],
            ['name' => 'Durlești'],
            ['name' => 'Sângera'],
            ['name' => 'Dnestrovsc'],
            ['name' => 'Crasnoe'],
            ['name' => 'Maiac'],
            ['name' => 'Biruința'],
            ['name' => 'Căinari'],
            ['name' => 'Ghindești'],
            ['name' => 'Tvardița'],
        ];
        City::insert($cities);
        }
}
