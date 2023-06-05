<?php

namespace Tests\Unit\Controller;

use Tests\TestCase;

class ArticleControllerTest extends TestCase
{

    public function testGetLocale()
    {
        $response = $this->get("/api/events/fr");
        $response->assertStatus(200);

        $response = $this->get("/api/events/fr?articlesPerPage=2");
        $response->assertStatus(200);

        $response = $this->get("/api/events/fr?articlesPerPage=lol");
        $response->assertStatus(400);
    }

    public function testApiGetArticles()
    {
        $response = $this->get('/api/events');
        $response->assertStatus(200);

        $response = $this->get('/api/events?articlesPerPage=2');
        $response->assertStatus(200);

        $response = $this->get('/api/events?articlesPerPage=lol');
        $response->assertStatus(400);
    }

    /**
     * Test de la recherche parmis les articles.
     * @return void
     */
    public function testApiSearch()
    {
        $response = $this->post('/api/events/search', [
            'titleFilter' => 'a',
            'descriptionFilter' => 'a',
            'from' => '2020-04-01 00:00:00',
            'to' => '2023-05-31 23:59:59',
            'articlesPerPage' => 6,
            'page' => 2
        ]);

        $response->assertStatus(200);

        $response = $this->post('/api/events/search', [
            'titleFilter' => 'a',
            'descriptionFilter' => 'a',
            'from' => 'Incorrect date',
            'to' => '2023-05-31 23:59:59',
            'articlesPerPage' => -1,
            'page' => 2
        ]);

        $response->assertStatus(400);
    }

    public function testGetArticleList() {
        $response = $this->get("/article-getlist-request");
        $response->assertStatus(200);

        $response = $this->get("/article-getlist-request?search=oldest");
        $response->assertStatus(200);

        $response = $this->get("/article-getlist-request?search=375jf");
        $response->assertStatus(400);
    }
}
