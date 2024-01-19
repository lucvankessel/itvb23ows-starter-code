<?php
use PHPUnit\Framework\TestCase;

class GrasshopperTest extends TestCase {}

// a. Een sprinkhaan verplaatst zich door in een rechte lijn een sprong te maken naar een veld meteen achter een andere steen in de richting van de sprong.
// een richting van de sprong is elk item in de offsets lijkt mij, door al deze door te lopen en bij elkaar op blijven tellen todat een leeg punt word berijkt.s

// b. Een sprinkhaan mag zich niet verplaatsen naar het veld waar hij al staat.
// c. Een sprinkhaan moet over minimaal één steen springen.
// d. Een sprinkhaan mag niet naar een bezet veld springen.
// e. Een sprinkhaan mag niet over lege velden springen. Dit betekent dat alle
// velden tussen de start- en eindpositie bezet moeten zijn.