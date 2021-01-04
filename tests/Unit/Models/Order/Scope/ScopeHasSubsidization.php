<?php

namespace Tests\Unit\Models\Order\Scope;

use App\Order;
use Tests\TestCase;

class ScopeHasSubsidization extends TestCase
{
    /** @test */
    public function order_has_subsidization()
    {
        $order = factory(Order::class)->create([
            'is_subsidized' => Order::IS_SUBSIDIZED
        ]);

        //вытаскиваем из базы первый order у которого есть subsidia
        $orderWithSubsidization = Order::hasSubsidization()->first();

        //смотрим чтобы такой order нашелся
        $this->assertNotNull($orderWithSubsidization);

        //смотрим чтобы найденный order был тем который изначально создавался
        $this->assertTrue($order->id === $orderWithSubsidization->id);
    }

    /** @test */
    public function order_has_not_subsidization() {
        //создаем в базе пост и явно указываем ему ссылку на видео
        factory(Post::class)->create([
            'video_url' => 'https://www.youtube.com/watch?v=lDT3ywRfJO0',
        ]);

        //ищем первый пост у котрого НЕТ видео
        /** @var Post $resPost */
        $resPost = Post::hasNotVideo()->first();

        //мы ожидаем что такого поста не будет
        $this->assertNull($resPost);
    }
}
