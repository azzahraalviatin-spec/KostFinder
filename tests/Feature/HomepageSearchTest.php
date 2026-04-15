<?php

namespace Tests\Feature;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_public_kosts(): void
    {
        $owner = User::factory()->create([
            'role' => 'owner',
            'status_verifikasi_identitas' => 'disetujui',
        ]);

        $kost = Kost::create([
            'owner_id' => $owner->id,
            'nama_kost' => 'Kost Mawar Surabaya',
            'alamat' => 'Jl. Mawar No. 10',
            'kota' => 'Surabaya',
            'tipe_kost' => 'Putri',
            'harga_mulai' => 1200000,
            'status' => 'aktif',
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee($kost->nama_kost);
    }

    public function test_homepage_can_filter_by_city_and_max_price(): void
    {
        $owner = User::factory()->create([
            'role' => 'owner',
            'status_verifikasi_identitas' => 'disetujui',
        ]);

        Kost::create([
            'owner_id' => $owner->id,
            'nama_kost' => 'Kost Melati Malang',
            'alamat' => 'Jl. Ijen No. 3',
            'kota' => 'Malang',
            'tipe_kost' => 'Putra',
            'harga_mulai' => 900000,
            'status' => 'aktif',
        ]);

        Kost::create([
            'owner_id' => $owner->id,
            'nama_kost' => 'Kost Anggrek Surabaya',
            'alamat' => 'Jl. Dharmahusada No. 8',
            'kota' => 'Surabaya',
            'tipe_kost' => 'Putri',
            'harga_mulai' => 1800000,
            'status' => 'aktif',
        ]);

        $response = $this->get('/?city=Malang&max_price=1000000');

        $response->assertOk();
        $response->assertSee('Kost Melati Malang');
        $response->assertDontSee('Kost Anggrek Surabaya');
    }
}
