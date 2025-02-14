<?php

namespace App\Entity;

class Card
{

    private string $value;

    private string $suit;

    private array $ranking = [
        '2' => 1,
        '3' => 2,
        '4' => 3,
        '5' => 4,
        '6' => 5,
        '7' => 6,
        '8' => 7,
        '9' => 8,
        'T' => 9,
        'J' => 10,
        'Q' => 11,
        'K' => 12,
        'A' => 13
    ];

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

    public function setValue(string $value): Card
    {
        $this->value = $value;
        return $this;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function setSuit(string $suit): Card
    {
        $this->suit = $suit;
        return $this;
    }

    public function __toString(): string
    {
        return $this->value . $this->suit;
    }

}