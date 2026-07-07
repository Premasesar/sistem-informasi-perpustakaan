<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnggotaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anggota_berhasil_disimpan_jika_semua_input_valid()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/anggota', [
            'nama'   => 'Budi Santoso',
            'alamat' => 'Jl. Malioboro No. 1, Yogyakarta',
            'no_hp'  => '081234567890',
            'email'  => 'budi.santoso@gmail.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors();
        $this->assertDatabaseHas('anggotas', ['email' => 'budi.santoso@gmail.com']);
    }

    /** @test */
    public function anggota_gagal_disimpan_jika_nama_mengandung_angka()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/anggota', [
            'nama'   => 'Budi Santoso 123',
            'alamat' => 'Jl. Malioboro No. 1',
            'no_hp'  => '081234567890',
            'email'  => 'budi@gmail.com',
        ]);

        $response->assertSessionHasErrors(['nama']);
    }

    /** @test */
    public function anggota_gagal_disimpan_jika_email_tidak_valid()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/anggota', [
            'nama'   => 'Budi Santoso',
            'alamat' => 'Jl. Malioboro No. 1',
            'no_hp'  => '081234567890',
            'email'  => 'budi-tanpa-arroba.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function anggota_gagal_disimpan_jika_no_hp_format_salah()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/anggota', [
            'nama'   => 'Budi Santoso',
            'alamat' => 'Jl. Malioboro No. 1',
            'no_hp'  => '021999',
            'email'  => 'budi@gmail.com',
        ]);

        $response->assertSessionHasErrors(['no_hp']);
    }
}
