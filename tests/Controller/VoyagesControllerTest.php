<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author Moi
 */
class VoyagesControllerTest extends WebTestCase{
    public function testAccesPage(){
        $client= static::createClient();
        $client->request('GET', '/voyages');
        $this ->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testContenuPage(){
        $client= static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this ->assertSelectorTextContains('h1', 'Mes voyages');
        $this ->assertSelectorTextContains('th', 'Ville');
        $this ->assertCount(4, $crawler->filter('th'));
        $this ->assertSelectorTextContains('h5', 'Vereeniging');
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client ->request('GET', '/voyages');
        $client ->clickLink('Vereeniging');
        $response = $client->getResponse();
        $this ->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client ->getRequest()->server->get("REQUEST_URI");
        $this ->assertEquals('/voyages/voyage/95', $uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client ->request('GET', '/voyages');
        //simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', ['recherche' =>'Ubud']);
        //vérifie le nb de lignes obtenus
        $this ->assertCount(1, $crawler->filter('h5'));
        //vérifie si la ville correspond à la recherche
        $this ->assertSelectorTextContains('h5', 'Ubud');
    }
}
