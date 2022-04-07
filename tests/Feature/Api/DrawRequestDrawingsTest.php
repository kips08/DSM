<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Drawing;
use App\Models\DrawRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DrawRequestDrawingsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_draw_request_drawings()
    {
        $drawRequest = DrawRequest::factory()->create();
        $drawings = Drawing::factory()
            ->count(2)
            ->create([
                'request_id' => $drawRequest->id,
            ]);

        $response = $this->getJson(
            route('api.draw-requests.drawings.index', $drawRequest)
        );

        $response->assertOk()->assertSee($drawings[0]->component_name);
    }

    /**
     * @test
     */
    public function it_stores_the_draw_request_drawings()
    {
        $drawRequest = DrawRequest::factory()->create();
        $data = Drawing::factory()
            ->make([
                'request_id' => $drawRequest->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.draw-requests.drawings.store', $drawRequest),
            $data
        );

        unset($data['rev']);
        unset($data['uploaded_at']);
        unset($data['uploaded_by']);
        unset($data['reviewed_at']);
        unset($data['reviewed_by']);
        unset($data['request_id']);

        $this->assertDatabaseHas('drawings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $drawing = Drawing::latest('id')->first();

        $this->assertEquals($drawRequest->id, $drawing->request_id);
    }
}
