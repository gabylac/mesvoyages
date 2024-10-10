<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;
use App\Entity\Environnement;

/**
 * Description of VisiteTest
 *
 * @author Moi
 */
class VisiteTest extends TestCase {
    public function testGetDatedreationString(){
        $visite = new Visite();
        $visite ->setDatecreation(new DateTime("2024-04-24"));
        $this->assertEquals("24/04/24", $visite ->getDatecreationString());
    }
    
    public function testAddEnvironnement(){
        $envi= (new Environnement())
                ->setNom("plage");
        $visite= new Visite();
        $visite->addEnvironnement($envi);
        $nbEnvironnementAvant = $visite->getEnvironnements()->count();
        $visite->addEnvironnement($envi);
        $nbEnvironnementApres = $visite->getEnvironnements()->count();
        $this->assertEquals($nbEnvironnementApres, $nbEnvironnementAvant, "ajout du même environnement devrait échouer");
    }
}
