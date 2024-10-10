<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * Description of VisiteValidationsTest
 *
 * @author Moi
 */
class VisiteValidationsTest extends KernelTestCase{
    public function getVisite(): Visite{
        return (new Visite())
                ->setVille("New York")
                ->setPays("USA");
    }
    
    public function testValidNoteVisite(){
        $visite = $this->getVisite()->setNote(10);
        $this ->assertErrors($visite, 0);
        $this ->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait réussir");
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait réussir");
    }
    
    public function assertErrors(Visite $visite, int $nbErreursAttendues, string $message=""){
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this ->assertCount($nbErreursAttendues, $error, $message);
    }
    
    public function testInvalidNoteVisite(){
        $visite = $this->getVisite()->setNote(-15);
        $this ->assertErrors($visite, 1);
        $this ->assertErrors($this->getVisite()->setNote(-1), 1, "-1 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(21), 1, "21 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-25), 1, "-25 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(25), 1, "25 devrait échouer");
    }
    
    public function testNonValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(50)
                ->setTempmax(13);
        $this ->assertErrors($visite, 1, "min=20 et max=18 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmax(20)->setTempmin(20), 1, "tempmax=20 et tempmin=20 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmax(15)->setTempmin(36), 1, "tempmax=15 et tempmin=36 devrait échouer");
    }
    
    public function testTempmaxValid(){   
        $visite = $this->getVisite()
                ->setTempmax(25)
                ->setTempmin(15);
        $this ->assertErrors($visite, 0, "tempmax=25 et tempmin=15 devrait réussir");
        $this-> assertErrors($this->getVisite()->setTempmin(19)->setTempmax(20), 0, "tempmax=20 et tempmin=19 devrait réussir");
    }
    
    public function testValidDatecreationVisite(){
        $aujourdhui= new DateTime();
        $this ->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourdhui devrait réussir");
        $hier = (new DateTime())->sub(new DateInterval("P5D"));
        $this ->assertErrors($this->getVisite()->setDatecreation($hier), 0, "hier devrait réussir");
    }
    
    public function testInvalidDatecreationVisite(){
        $demain = (new \DateTime())->add(new DateInterval("P1D"));
        $this ->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plutard = (new DateTime())->add(new DateInterval("P5D"));
        $this ->assertErrors($this->getVisite()->setDatecreation($plutard), 1, "plutard devrait échouer");
    }
}
