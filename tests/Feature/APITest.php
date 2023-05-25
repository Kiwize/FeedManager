<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APITest extends TestCase
{
    /**
     * Test de la recherche parmis les articles.
     * @return void
     */
    public function testApiSearch()
    {
        $response = $this->post('/api/events/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00',
            'to' => '2023-04-31 23:59:59'
        ]);
    
        $response->assertStatus(200);
    }

    public function testApiGetArticles() {
        $response = $this->get('/api/events');
        $response->assertStatus(200);
    }
}
