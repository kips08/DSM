<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\DrawRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyDrawRequestsTest extends TestCase
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
    public function it_gets_company_draw_requests()
    {
        $company = Company::factory()->create();
        $drawRequests = DrawRequest::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.draw-requests.index', $company)
        );

        $response->assertOk()->assertSee($drawRequests[0]->number);
    }

    /**
     * @test
     */
    public function it_stores_the_company_draw_requests()
    {
        $company = Company::factory()->create();
        $data = DrawRequest::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.draw-requests.store', $company),
            $data
        );

        $this->assertDatabaseHas('draw_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $drawRequest = DrawRequest::latest('id')->first();

        $this->assertEquals($company->id, $drawRequest->company_id);
    }
}
