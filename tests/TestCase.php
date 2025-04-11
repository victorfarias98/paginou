<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configura o guard padrão para api
        config(['auth.defaults.guard' => 'api']);
        
        // Configura o provider do JWT com uma chave de 32 caracteres (256 bits)
        config(['jwt.secret' => 'test-key-1234567890-abcdefghijklmnopqrstuvwxyz']);
    }
}
