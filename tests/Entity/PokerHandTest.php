<?php

namespace App\Tests\Entity;

use App\Entity\PokerHand;
use App\Exception\InvalidCardListException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PokerHandTest extends KernelTestCase
{

    public function testComparePairVsPair(): void
    {
        try {
            $firstHand = new PokerHand("AD QS AS TD 4D");
            $secondHand = new PokerHand("QH QS AS TD 2S");

            $this->assertEquals(1, $firstHand->compareWith($secondHand));
        } catch (InvalidCardListException $e) {
            $this->addWarning($e->getMessage());
        }

    }

    public function testCompareTwoPairVsPair(): void
    {
        try {
            $firstHand = new PokerHand("QH QS AS TD 2S");
            $secondHand = new PokerHand("AD QS AS TD TS");

            $this->assertEquals(2, $firstHand->compareWith($secondHand));
        } catch (InvalidCardListException $e) {
            $this->addWarning($e->getMessage());
        }

    }

    public function testCompareTieStraight(): void
    {
        try {
            $firstHand = new PokerHand("AC QS KD JS TS");
            $secondHand = new PokerHand("AD QS KD JS TD");

            $this->assertEquals(3, $firstHand->compareWith($secondHand));
        } catch (InvalidCardListException $e) {
            $this->addWarning($e->getMessage());
        }

    }

}