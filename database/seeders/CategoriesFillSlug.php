<?php

namespace Database\Seeders;

use App\Models\Category;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class CategoriesFillSlug extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        $categories = Category::all()->map(function ($item) {
            $item['slug'] = Str::slug($item['title']);
            return $item;
        });

        $categories->each(function($item) {
            Category::where('id', '=', $item['id'])->update(['slug' => $item['slug']]);
        });


        DB::commit();
    }
}
