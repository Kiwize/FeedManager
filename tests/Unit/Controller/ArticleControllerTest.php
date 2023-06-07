<?php

namespace Tests\Unit\Controller;

use Carbon\Carbon;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ArticleControllerTest extends TestCase
{

    public function testGetLocales()
    {
        $response = $this->get("/api/articles/locales");
        $response->assertStatus(200);
    }

    public function testFetch()
    {
        $response = $this->get('/api/articles');
        $response->assertStatus(400);

        $response = $this->get('/api/articles?results=20&resultsPerPage=6&page=2');
        $response->assertStatus(200);

        $response = $this->get('/api/articles?results=20&page=2');
        $response->assertStatus(200);
        assertEquals($response['current_page'], '2');

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
            'resultsPerPage' => 6,
            'page' => 2,
            'locale' => 'fr'
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
            'resultsPerPage' => 6,
            'page' => 2,
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
            'page' => 2,
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/articles/search', [
            'from' => '2020-04-01 00:00:00',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
            'page' => 2,
        ]);
        $response->assertStatus(200);

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
        ]);
        $response->assertStatus(400);

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00test',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
            'resultsPerPage' => 6,
            'page' => 2,
        ]);
        $response->assertStatus(400);

        $response = $this->post('/api/articles/search', [
            'titleFilter' => '',
            'descriptionFilter' => '',
            'from' => '2020-04-01 00:00:00',
        ]);
        $response->assertStatus(400);

        $response = $this->post('/api/articles/search', [
            'from' => '2020-04-01 00:00:00',
            'to' => Carbon::now()->toDate()->format('Y-m-d H:i:s'),
        ]);
        $response->assertStatus(400);
    }

    public function testRefresh() {
        $response = $this->get('/api/articles/refresh');
        $response->assertStatus(200);
    }
}
