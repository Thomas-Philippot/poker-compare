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
        return count($this->firstHand->getCards()) !== count(array_unique($this->firstHand->getCards())) ||
            count($this->secondHand->getCards()) !== count(array_unique($this->secondHand->getCards()));
    }

}