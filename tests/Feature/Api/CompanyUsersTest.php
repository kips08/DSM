<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyUsersTest extends TestCase
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
    public function it_gets_company_users()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();

        $company->users()->attach($user);

        $response = $this->getJson(
            route('api.companies.users.index', $company)
        );

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_company()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.companies.users.store', [$company, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $company
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_company()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.companies.users.store', [$company, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $company
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
