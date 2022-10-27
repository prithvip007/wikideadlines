<?php
namespace Seeds;
use Illuminate\Database\Seeder;
use \App\Models\County;

class CountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counties = [
            ['name' => 'Alameda', 'e_filing' => 'mandatory'],
            ['name' => 'Alpine', 'e_filing' => 'not available'],
            ['name' => 'Amador', 'e_filing' => 'not available'],
            ['name' => 'Butte', 'e_filing' => 'mandatory'],
            ['name' => 'Colusa', 'e_filing' => 'not available'],
            ['name' => 'Contra Costa', 'e_filing' => 'not available'],
            ['name' => 'Calaveras', 'e_filing' => 'permissive'],
            ['name' => 'Del Norte', 'e_filing' => 'not available'],
            ['name' => 'El Dorado', 'e_filing' => 'not available'],
            ['name' => 'Fresno', 'e_filing' => 'not available'],
            ['name' => 'Glenn', 'e_filing' => 'not available'],
            ['name' => 'Humboldt', 'e_filing' => 'not available'],
            ['name' => 'Imperial', 'e_filing' => 'mandatory'],
            ['name' => 'Inyo', 'e_filing' => 'not available'],
            ['name' => 'Kern', 'e_filing' => 'mandatory'],
            ['name' => 'Kings', 'e_filing' => 'mandatory'],
            ['name' => 'Lake', 'e_filing' => 'not available'],
            ['name' => 'Lassen', 'e_filing' => 'not available'],
            ['name' => 'Los Angeles', 'e_filing' => 'mandatory'],
            ['name' => 'Madera', 'e_filing' => 'not available'],
            ['name' => 'Marin', 'e_filing' => 'not available'],
            ['name' => 'Mariposa', 'e_filing' => 'not available'],
            ['name' => 'Mendocino', 'e_filing' => 'mandatory'],
            ['name' => 'Merced', 'e_filing' => 'mandatory'],
            ['name' => 'Modoc', 'e_filing' => 'not available'],
            ['name' => 'Mono', 'e_filing' => 'not available'],
            ['name' => 'Monterey', 'e_filing' => 'mandatory'],
            ['name' => 'Napa', 'e_filing' => 'permissive'],
            ['name' => 'Nevada', 'e_filing' => 'not available'],
            ['name' => 'Orange', 'e_filing' => 'mandatory'],
            ['name' => 'Placer', 'e_filing' => 'mandatory'],
            ['name' => 'Plumas', 'e_filing' => 'not available'],
            ['name' => 'Riverside', 'e_filing' => 'mandatory'],
            ['name' => 'Sacramento', 'e_filing' => 'not available'],
            ['name' => 'San Benito', 'e_filing' => 'not available'],
            ['name' => 'San Bernardino', 'e_filing' => 'not available'],
            ['name' => 'San Diego', 'e_filing' => 'mandatory'],
            ['name' => 'San Francisco', 'e_filing' => 'mandatory'],
            ['name' => 'San Luis Obispo', 'e_filing' => 'mandatory'],
            ['name' => 'San Mateo', 'e_filing' => 'mandatory'],
            ['name' => 'Santa Barbara', 'e_filing' => 'mandatory'],
            ['name' => 'Santa Clara', 'e_filing' => 'mandatory'],
            ['name' => 'Santa Cruz', 'e_filing' => 'mandatory'],
            ['name' => 'Shasta', 'e_filing' => 'not available'],
            ['name' => 'Sierra', 'e_filing' => 'not available'],
            ['name' => 'Solano', 'e_filing' => 'not available'],
            ['name' => 'Sonoma', 'e_filing' => 'mandatory'],
            ['name' => 'Stanislaus', 'e_filing' => 'mandatory'],
            ['name' => 'Sutter', 'e_filing' => 'mandatory'],
            ['name' => 'Tehama', 'e_filing' => 'permissive'],
            ['name' => 'Trinity', 'e_filing' => 'not available'],
            ['name' => 'Tulare', 'e_filing' => 'permissive'],
            ['name' => 'Tuolumne', 'e_filing' => 'not available'],
            ['name' => 'Ventura', 'e_filing' => 'not available'],
            ['name' => 'Yolo', 'e_filing' => 'mandatory'],
            ['name' => 'Yuba', 'e_filing' => 'mandatory'],
        ];
        foreach ($counties as $county) {
            County::create([
                'name' => $county['name'],
                'e_filing' => $county['e_filing'],
                'state_id' => 1,
            ]);
        }
    }
}
