<?php
namespace tests\Feature\Controllers;

use App\Models\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\api\LogController
 * @uses \App\Models\Log
 * @uses \Database\Factories\LogFactory
 */
class LogControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_count_of_logs_without_filter()
    {
        Log::factory()->create();
        $response = $this->json('GET', '/api/logs/count');

        $response->assertStatus(200)
            ->assertJson(['count' => 1]);
    }

//    /** @test */
//    public function it_returns_count_of_logs_with_filter_and_have_result()
//    {
//        // Create some sample logs
//        // create request with some filters that exist in log samples
//        // assert count of result based on data and filters
//    }

//    /** @test */
//    public function it_returns_count_of_logs_with_filter_and_no_result()
//    {
//        // Create some sample logs
//        // create request with some filters that dont exist in log samples
//        // assert count of result based on data and filters
//    }

    /** @test */
    public function it_returns_422_if_start_date_is_not_a_valid_date()
    {
        $response = $this->json('GET', '/api/logs/count', [
            'service_name' => 'service1',
            'start_date' => 'invalid date',
            'end_date' => now()->format('Y-m-d')
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['start_date']);
    }

    /** @test */
    public function it_returns_422_if_end_date_is_not_a_valid_date()
    {
        $response = $this->json('GET', '/api/logs/count', [
            'service_name' => 'service1',
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => 'invalid date'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    /** @test */
    public function it_returns_422_if_service_name_does_not_exist_in_logs_table()
    {
        $response = $this->json('GET', '/api/logs/count', [
            'service_name' => 'non-existent service',
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d')
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['service_name']);
    }
}
