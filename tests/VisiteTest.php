<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Visite;
use PHPUnit\Framework\TestCase;

/**
 * Description of VisiteTest
 *
 * @author Moi
 */
class VisiteTest extends TestCase {
    public function testGetDatedreationString(){
        $visite = new Visite();
        $visite ->setDatecreation(new \DateTime("2024-04-24"));
        $this->assertEquals("24/04/24", $visite ->getDatecreationString());
    }
}
