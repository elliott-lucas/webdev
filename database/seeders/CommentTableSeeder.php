<?php

namespace Database\Seeders;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $c = new Comment;
        // $c->user_id = 1;
        // $c->post_id = 1;
        // $c->text = "I agree with this post!";
        // $c->date_posted = "2010-06-19 18:40:51";
        // $c->save();
        $comments = Comment::factory()->count(100)->create();
    }
}
