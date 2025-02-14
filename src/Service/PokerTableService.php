<?php

namespace App\Service;

use App\Entity\PokerHand;
use App\Exception\DuplicatedCardsException;
use App\Exception\InvalidCardListException;

class PokerTableService
{

    private PokerHand $firstHand;

    private PokerHand $secondHand;

    /**
     * @throws InvalidCardListException
     */
    public function __construct($firstPlayer, $secondPlayer)
    {
        $this->firstHand = new PokerHand($firstPlayer);
        $this->secondHand = new PokerHand($secondPlayer);
    }

    /**
     * @throws DuplicatedCardsException
     */
    public function play(): int
    {

        if ($this->tableHaveDuplicates()) {
            throw new DuplicatedCardsException("Duplicated cards found, someone might be cheating!");
        }

        return $this->firstHand->compareWith($this->secondHand);

    }

    private function tableHaveDuplicates(): bool
    {
        $array = array_merge($this->firstHand->getCards(), $this->secondHand->getCards());
        return count($array) !== count(array_unique($array));
    }

}