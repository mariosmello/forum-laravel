<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get("Location"))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    function an_thread_requires_fields()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');

        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');

        factory('App/Channel', 2);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @/** @test */
    function guest_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');
        $response = $this->delete( $thread->path());
        $response->assertRedirect('/login');
    }

    /** @test */
    function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    /** @teste */
    function threads_may_only_be_deleted_by_those_who_have_permission()
    {
        // @TODO
    }

    function publishThread($overides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overides);

        return $this->post('/threads', $thread->toArray());
    }
}
