<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Disable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete old data in correct order
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('suppliers')->truncate();

        // Enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
