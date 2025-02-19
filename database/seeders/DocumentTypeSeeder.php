<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('document_types')->insert([
            ['name' => 'DNI'],
            ['name' => 'RUC'],
            ['name' => 'Carnet de Extranjería'],
            ['name' => 'Pasaporte'],
            ['name' => 'Otro'],
        ]);
    }
}
