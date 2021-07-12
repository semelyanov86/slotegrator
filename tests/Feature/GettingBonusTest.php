<?php

declare(strict_types=1);


namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GettingBonusTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testCreateTransactionWork(): void
    {
        $this->actingAs(
            User::all()->first()
        );
        $response = $this->post(route('bonus'), []);
        $response->assertRedirect(route('welcome'));
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('transactions', 1);
    }
}
