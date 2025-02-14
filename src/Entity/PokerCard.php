<?php

namespace App\Entity;

class PokerCard extends AbstractPokerRules
{

    private string $value;

    private string $suit;

    /**
     * @param string $value
     * @param string $suit
     */
    public function __construct(string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getRank(): int
    {
        return $this->ranking[$this->value];
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): PokerCard
    {
        $this->value = $value;
        return $this;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function setSuit(string $suit): PokerCard
    {
        $this->suit = $suit;
        return $this;
    }

    public function __toString(): string
    {
        return $this->value . $this->suit;
    }

}