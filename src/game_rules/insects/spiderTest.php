<?php

use PHPUnit\Framework\TestCase;

class SpiderTest extends TestCase {}

// a. Een spin verplaatst zich door precies drie keer te verschuiven.
// b. Een verschuiving is een zet zoals de bijenkoningin die mag maken.
// c. Een spin mag zich niet verplaatsen naar het veld waar hij al staat.
// d. Een spin mag alleen verplaatst worden over en naar lege velden.
// e. Een spin mag tijdens zijn verplaatsing geen stap maken naar een veld waar hij
// tijdens de verplaatsing al is geweest.