<?php
use PHPUnit\Framework\TestCase;
use insects\grasshopper;

class GrasshopperTest extends TestCase {

    public function testGrasshopperMovesInStraightLine() {
        $grasshopper = new grasshopper\Grasshopper();

        $board = [
            "0,0" => [],
            "0,1" => []
        ];

        // a. Een sprinkhaan verplaatst zich door in een rechte lijn een sprong te maken naar een veld meteen achter een andere steen in de richting van de sprong.
        $this->assertTrue($grasshopper->validMove($board, "0,0", "0,2"));
    }

    public function testGrasshopperCantMoveToFieldItIsAlreadyOn() {
        $grasshopper = new grasshopper\Grasshopper();

        $board = [
            "0,0" => [],
            "0,1" => []
        ];

        // b. Een sprinkhaan mag zich niet verplaatsen naar het veld waar hij al staat.
        $this->assertFalse($grasshopper->validMove($board, "0,0", "0,0"));
    }

    public function testGrasshopperMustJumpOverAtleastOneStone() {
        $grasshopper = new grasshopper\Grasshopper();

        $board = [
            "0,0" => []
        ];

        // c. Een sprinkhaan moet over minimaal één steen springen.
        $this->assertFalse($grasshopper->validMove($board, "0,0", "0,1"));
    }

    public function testGrasshopperCantJumpToOccupiedField() {
        $grasshopper = new grasshopper\Grasshopper();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,2" => []
        ];
        // d. Een sprinkhaan mag niet naar een bezet veld springen.
        $this->assertFalse($grasshopper->validMove($board, "0,0", "0,2"));
    }

    public function testGrasshopperMustJumpOverOccupiedLineOfTiles() {
        $grasshopper = new grasshopper\Grasshopper();

        $board = [
            "0,0" => [],
            "0,1" => [],
            "0,3" => []
        ];

        // e. Een sprinkhaan mag niet over lege velden springen. Dit betekent dat alle velden tussen de start- en eindpositie bezet moeten zijn.
        $this->assertFalse($grasshopper->validMove($board, "0,0", "0,4"));
    }
}