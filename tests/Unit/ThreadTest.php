<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    private $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');

    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',
            $this->thread->replies);
    }

    /** @test */
    public function it_has_an_creator()
    {
        $this->assertInstanceOf('App\User',
            $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {

        $path = '/threads/' . $this->thread->channel->slug . '/' . $this->thread->id;

        $this->assertEquals($path, $this->thread->path());

    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);

    }

    /** @teste */
    public function a_thread_belongs_to_a_channel()
    {

        $this->assertInstanceOf('App\Channel', $this->thread->channel);

    }
}
