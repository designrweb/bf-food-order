<?php

namespace Tests\Feature\Api\Routing\PosApplication;

use Tests\TestCase;

class PosApplicationApiRoutesTest extends TestCase
{
    /** @test */
    public function itResponsesOnGetAllConsumersRequest()
    {
        $response = $this->post('/api/v1/pos/consumer');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetSearchConsumerRequest()
    {
        $response = $this->post('/api/v1/pos/search/consumer');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnSearchConsumerByQrCodeRequest()
    {
        $response = $this->post('/api/v1/pos/search/consumer-qr-code');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnCreateFoodOrderRequest()
    {
        $response = $this->post('/api/v1/pos/order/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetLimitOrdersRequest()
    {
        $response = $this->get('/api/v1/pos/order/limit');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetOrdersStatistic()
    {
        $response = $this->get('/api/v1/pos/order/statistic');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetHistoryRequest()
    {
        $response = $this->get('/api/v1/pos/history');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetAllMenuItemsRequest()
    {
        $response = $this->get('/api/v1/pos/menuitem');

        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnGetMenuItemRequest()
    {
        $response = $this->get('/api/v1/pos/menus/${id}');

        $response->assertStatus(200);
    }

}
