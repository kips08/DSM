<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DrawRequest;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DrawRequestTest extends TestCase
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
    public function it_gets_draw_requests_list()
    {
        $drawRequests = DrawRequest::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.draw-requests.index'));

        $response->assertOk()->assertSee($drawRequests[0]->number);
    }

    /**
     * @test
     */
    public function it_stores_the_draw_request()
    {
        $data = DrawRequest::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.draw-requests.store'), $data);

        $this->assertDatabaseHas('draw_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_draw_request()
    {
        $drawRequest = DrawRequest::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'number' => $this->faker->text(255),
            'object_name' => $this->faker->text(255),
            'ship_type' => $this->faker->text(255),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(
            route('api.draw-requests.update', $drawRequest),
            $data
        );

        $data['id'] = $drawRequest->id;

        $this->assertDatabaseHas('draw_requests', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_draw_request()
    {
        $drawRequest = DrawRequest::factory()->create();

        $response = $this->deleteJson(
            route('api.draw-requests.destroy', $drawRequest)
        );

        $this->assertSoftDeleted($drawRequest);

        $response->assertNoContent();
    }
}
