<?php
namespace Tests\Unit\Controller\Web;
use Tests\TestCase;



class SearchControllerTest extends TestCase
{
    public function testSearch() {

        $response = $this->get('/sources');
        $response->assertStatus(200);

        $response = $this->get('/sources?nameFilter=a&localeFilter=fr');
        $response->assertStatus(200);

        $response = $this->get('/sources?nameFilter=lol&localeFilter=zboob');
        $response->assertStatus(400);
    }
}
