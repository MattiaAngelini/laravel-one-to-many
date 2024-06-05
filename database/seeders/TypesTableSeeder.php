<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;


class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'WebApplication',
            'MobileApplication',
            'DesktopApplication',
            'API',
            'Library'
        ];

        foreach ($types as $TypeName) {
            $newType = new Type();
            $newType->name = $TypeName;
            $newType->slug = Str::slug($newType->name, '-');
            $newType->save();

        }
    }
}
