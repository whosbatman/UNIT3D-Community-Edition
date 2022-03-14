<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
class PostControllerTest extends TestCase
{
    /** @test */
    public function post_delete_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $post = \App\Models\Post::factory()->create();

        $response = $this->delete(route('forum_post_delete', ['postId' => $post->postId]));

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /** @test */
    public function post_edit_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $post = \App\Models\Post::factory()->create();

        $response = $this->post(route('forum_post_edit', ['postId' => $post->postId]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(withSuccess(\trans('forum.edit-post-success')));

        // TODO: perform additional assertions
    }

    /** @test */
    public function post_edit_form_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $topic = \App\Models\Topic::factory()->create();
        $post = \App\Models\Post::factory()->create();

        $response = $this->get(route('forum_post_edit_form', ['id' => $post->id, 'postId' => $post->postId]));

        $response->assertOk();
        $response->assertViewIs('forum.post_edit');
        $response->assertViewHas('topic', $topic);
        $response->assertViewHas('forum');
        $response->assertViewHas('post', $post);
        $response->assertViewHas('category');

        // TODO: perform additional assertions
    }

    /** @test */
    public function reply_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $topic = \App\Models\Topic::factory()->create();
        $forum = \App\Models\Forum::factory()->create();
        $post = \App\Models\Post::factory()->create();

        $response = $this->post(route('forum_reply', ['id' => $post->id]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(withSuccess(\trans('forum.reply-topic-success')));

        // TODO: perform additional assertions
    }

    // test cases...
}