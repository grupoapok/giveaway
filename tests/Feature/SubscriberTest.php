<?php

namespace Tests\Feature;

use App\Subscriber;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriberTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $subscriber = factory(Subscriber::class)->create();
        $response = $this->post('/api/subscriber', [
            'email'    => $subscriber->email,
            'name'     => $subscriber->name,
            'language' => 'spanish'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['data'=>[
            'id','name','email','token','country','city','region'
        ]]);
        $this->assertDatabaseHas('subscriber',[
            'email'    => $subscriber->email,
            'name'     => $subscriber->name,
            'language' => 'spanish'
        ]);
    }
}
