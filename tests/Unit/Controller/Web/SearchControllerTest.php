<?php
namespace Tests\Unit\Controller\Web;
use Tests\TestCase;



class SearchControllerTest extends TestCase
{
    public function testSearch() {

        $response = $this->get('/manager');
        $response->assertStatus(200);

        $response = $this->get('/manager?nameFilter=a&localeFilter=fr');
        $response->assertStatus(200);

        $response = $this->get('/manager?nameFilter=lol&localeFilter=zboob');
        $response->assertStatus(400);
    }
}
