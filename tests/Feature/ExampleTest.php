<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Halaman utama (/) harus redirect ke halaman login,
     * karena aplikasi ini mewajibkan autentikasi terlebih dahulu.
     */
    public function test_halaman_utama_redirect_ke_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }
}