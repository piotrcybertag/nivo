<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_a_landing_locale(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $loc = $response->headers->get('Location', '');
        $this->assertTrue(
            str_contains($loc, '/pl/landing') || str_contains($loc, '/en/landing'),
            'Expected redirect to /pl/landing or /en/landing, got: '.$loc
        );
    }

    public function test_polish_landing_page_returns_ok(): void
    {
        $this->get('/pl/landing')->assertOk();
    }

    public function test_english_login_page_returns_ok(): void
    {
        $this->get('/en/login')->assertOk();
    }
}
