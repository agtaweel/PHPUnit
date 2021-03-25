<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    function a_user_can_like_a_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->be($user);
        $post->like();
        $this->assertDatabaseHas('likes',[
                'user_id'=>$user->id,
                'likable_id'=>$post->id,
                'likable_type'=>get_class($post)
            ]
        );
        $this->assertTrue($post->isLiked());
    }

    /** @test */
    function a_user_can_unlike_a_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->be($user);
        $post->unLike();

        $this->assertDatabaseMissing('likes',[
                'user_id'=>$user->id,
                'likable_id'=>$post->id,
                'likable_type'=>get_class($post)
            ]
        );

        $this->assertFalse($post->isLiked());
    }


    /** @test */
    function a_user_can_toggle_a_like_on_a_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->be($user);
        $post->toggleLike();
        $this->assertTrue($post->isLiked());
        $post->toggleLike();
        $this->assertFalse($post->isLiked());
    }


    /** @test */
    function a_user_can_know_how_many_likes_has()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $this->be($user);
        $post->toggleLike();
        $this->assertEquals($post->getLikesAttributeCount(),1);
        $post->toggleLike();
        $this->assertEquals($post->getLikesAttributeCount(),0);
    }
}
