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

    function publishThread($overides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overides);

        return $this->post('/threads', $thread->toArray());
    }
}
