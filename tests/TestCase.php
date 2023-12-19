<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

        /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_basic_request()
    {
        $response = $this->get('/api/healthcheck');
 
        $response->assertStatus(200);
    }

    public function login() {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'password'
        ]);
    
        $response->assertStatus(200)->assertJson([
            'success' => true
        ]);
    }
}
