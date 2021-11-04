<?php

namespace Database\Seeders;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $p = new Post;
        // $p->user_id = 1;
        // $p->text = "I think cheese is pretty tasty. Anyone else agree?";
        // $p->date_posted = "2010-06-19 18:34:42";
        // $p->save();
        $posts = Post::factory()->count(100)->create();
    }
}
