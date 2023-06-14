<?php
namespace Tests\Unit\Controller\Web;
use Tests\TestCase;



class ArticleControllerTest extends TestCase
{
    public function testFetchLatest() {

        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/?localeFilter=456');
        $response->assertStatus(400);

        $response = $this->get('/?localeFilter=fr&resultsPerPage=20');
        $response->assertStatus(200);
    }
}
