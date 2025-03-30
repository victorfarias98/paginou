<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configura o guard padrão para api
        config(['auth.defaults.guard' => 'api']);
        
        // Configura o provider do JWT
        config(['jwt.secret' => 'test-key']);
    }
}
