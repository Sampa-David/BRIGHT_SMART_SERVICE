<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Supabase\Client;

class SupabaseRlsPoliciesTest extends TestCase
{
    protected $supabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->supabase = new Client(
            env('SUPABASE_URL'),
            env('SUPABASE_KEY'),
            ['autoRefreshToken' => false]
        );
    }

    public function test_public_can_view_services()
    {
        $response = $this->supabase
            ->from('services')
            ->select('*')
            ->execute();

        $this->assertTrue(isset($response->data));
    }

    public function test_public_can_view_testimonials()
    {
        $response = $this->supabase
            ->from('testimonials')
            ->select('*')
            ->execute();

        $this->assertTrue(isset($response->data));
    }

    public function test_user_can_only_view_own_service_requests()
    {
        // Simuler un utilisateur connecté
        $token = 'user-jwt-token';
        $this->supabase->auth()->setToken($token);

        $response = $this->supabase
            ->from('service_requests')
            ->select('*')
            ->execute();

        $this->assertTrue(isset($response->data));
        // Vérifier que tous les service_requests appartiennent à l'utilisateur
        foreach ($response->data as $request) {
            $this->assertEquals($request->user_id, 'user-id');
        }
    }

    public function test_admin_can_view_all_service_requests()
    {
        // Simuler un admin connecté
        $token = 'admin-jwt-token';
        $this->supabase->auth()->setToken($token);

        $response = $this->supabase
            ->from('service_requests')
            ->select('*')
            ->execute();

        $this->assertTrue(isset($response->data));
        // L'admin devrait voir toutes les demandes
        $this->assertGreaterThan(0, count($response->data));
    }
}