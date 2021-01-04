<?php

namespace Tests\Unit\Models\User\Factory;

use App\User;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    /** @test */
    public function user_factory_persists_one_entity_to_database()
    {
        $user = factory(User::class)->create([
            'email' => 'user@example.com',
        ]);

        $this->assertDatabaseCount($user->getTable(), 1);

        $this->assertDatabaseHas($user->getTable(), [
            'email' => 'user@example.com',
        ]);
    }

    /** @test */
    public function user_factory_persists_many_entities_to_database()
    {
        factory(User::class, 10)->create();

        $this->assertDatabaseCount('users', 10);
    }
}
