<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            $title = $faker->sentence();
            $content = $faker->paragraph();
            $created_by = $faker->name();
            $imageName = 'none';
            $slug = Str::slug($title, '-');
            $isPinned = $faker->boolean(10);

            $data = [
                'title' => $title,
                'content' => $content,
                'created_by' => $created_by,
                'slug' => $slug,
                'is_pinned' => $isPinned,
                'image' => $imageName,
                'created_at' => now(),
                'updated_at' => now()
            ];

            Post::create($data);
        }
    }
}
