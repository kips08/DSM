<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DrawRequest;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DrawRequestControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_draw_requests()
    {
        $drawRequests = DrawRequest::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('draw-requests.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.draw_requests.index')
            ->assertViewHas('drawRequests');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_draw_request()
    {
        $response = $this->get(route('draw-requests.create'));

        $response->assertOk()->assertViewIs('app.draw_requests.create');
    }

    /**
     * @test
     */
    public function it_stores_the_draw_request()
    {
        $data = DrawRequest::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('draw-requests.store'), $data);

        $this->assertDatabaseHas('draw_requests', $data);

        $drawRequest = DrawRequest::latest('id')->first();

        $response->assertRedirect(route('draw-requests.edit', $drawRequest));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_draw_request()
    {
        $drawRequest = DrawRequest::factory()->create();

        $response = $this->get(route('draw-requests.show', $drawRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.draw_requests.show')
            ->assertViewHas('drawRequest');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_draw_request()
    {
        $drawRequest = DrawRequest::factory()->create();

        $response = $this->get(route('draw-requests.edit', $drawRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.draw_requests.edit')
            ->assertViewHas('drawRequest');
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

        $response = $this->put(
            route('draw-requests.update', $drawRequest),
            $data
        );

        $data['id'] = $drawRequest->id;

        $this->assertDatabaseHas('draw_requests', $data);

        $response->assertRedirect(route('draw-requests.edit', $drawRequest));
    }

    /**
     * @test
     */
    public function it_deletes_the_draw_request()
    {
        $drawRequest = DrawRequest::factory()->create();

        $response = $this->delete(route('draw-requests.destroy', $drawRequest));

        $response->assertRedirect(route('draw-requests.index'));

        $this->assertSoftDeleted($drawRequest);
    }
}
