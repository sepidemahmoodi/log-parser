<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => 'microservice',
            'service_name' => 'order',
            'date_time' => date('Y-m-d H:i:s'),
            'Http_method' => 'POST',
            'Http_path' => '/order',
            'Http_version' => 'HTTP/1.1',
            'Http_status_code' => 200
        ];
    }
}
