<?php

namespace Tests\Feature;

use App\Jobs\ProcessImage;
use App\User;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageCreateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testQueueSingleImageCreate()
    {
        Bus::fake();

        $user = factory(User::class)->create();

        $source_url = 'http://squirrelworld.com/bushytail.jpg';

        $response = $this->actingAs($user)
                         ->post(
                             '/image',
                             [
                                 'image_url' => $source_url,
                             ]
                         );

        $response->assertRedirect('/image');
        $response->assertSessionHas('status', 'Image Queued For Processing!');

        Bus::assertDispatched(
            ProcessImage::class,
            function ($job) use ($source_url) {
                return $job->image->source_url === $source_url;
            }
        );
    }
}
