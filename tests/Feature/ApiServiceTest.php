<?php

namespace Tests\Feature;

use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    /** @test */
    public function it_returns_data_when_api_request_is_successful()
    {
        // サービスを呼び出す
        $apiService = new ApiService();
        $result = $apiService->fetchData();

        // 期待される結果をアサート
        $this->assertNotNull($result);
        $this->assertArrayHasKey('game_indices', $result);
    }
}
