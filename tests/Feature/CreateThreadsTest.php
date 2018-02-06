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
    function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete( $thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete( $thread->path())
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_deletea_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    function publishThread($overides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overides);

        return $this->post('/threads', $thread->toArray());
    }
}
