<?php

namespace Tests\Unit\Models\User\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class UserSchemaTest extends TestCase
{
    /** @test */
    public function users_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id',
                'email',
                'email_verified_at',
                'password',
                'role',
                'remember_token',
                'created_at',
                'updated_at',
                'deleted_at',
            ]), 1);
    }
}
