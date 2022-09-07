<?php

namespace App\Tests;

use App\Controller\ProductController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DemoControllerTest extends WebTestCase
{
    public function testHomeCanBeShown(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Accueil');
    }

    public function testDemoCanBeShown()
    {
        $client = static::createClient();
        $client->request('GET', '/demo/fiofio');

        $this->assertSelectorTextContains('h1', 'Voici fiofio');
    }

    public function testDemoCannotBeShownIfLettersInParam()
    {
        $client = static::createClient();
        $client->request('GET', '/demo/éééé');

        // $this->assertSelectorTextContains('h1', 'Demo page numéro 42');
        $this->assertResponseStatusCodeSame(404);
    }

    public function testOnePlusOneEqualOne()
    {
        $this->assertEquals(2, 1 + 1);
        $this->assertTrue(true);
        $this->assertFalse(false);

        $client = static::createClient();
        $client->request('GET', '/product?price=100');

        $this->assertSelectorTextNotContains('td', 'iPhone X');

        $client->request('GET', '/product');

        $this->assertSelectorTextContains('td', 'iPhone X');
    }
}
