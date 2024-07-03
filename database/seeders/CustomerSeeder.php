<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Mark',
            'kg' => '5',
            'phoneno' => '0142920222',
            'pickuptime' => 'PM',
            'date' => Carbon::createFromFormat('d/m/Y', '30/1/2024')->format('Y-m-d'),
        ]);
    }
}
