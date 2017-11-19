<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_may_no_participate_in_forum_threads()
    {
        $this->withExceptionHandling();

        create('App\User');
        $thread = create('App\Thread');
        $reply = create('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $user = create('App\User');
        $this->be($user);

        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}
