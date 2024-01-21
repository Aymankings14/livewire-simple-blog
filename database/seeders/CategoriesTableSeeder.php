<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
           'name' =>'web Development'
        ]);
        Category::create([
           'name' =>'web Designer'
        ]);
        Category::create([
           'name' =>'mobile Development'
        ]);
    }
}
