<?php

namespace App\Entity;

abstract class AbstractPokerRules
{

    protected const ROYAL_FLUSH_SCORE = 100000;
    protected const STRAIGHT_FLUSH_SCORE = 90000;
    protected const FOUR_OF_A_KIND_SCORE = 80000;
    protected const FULL_HOUSE_SCORE = 70000;
    protected const FLUSH_SCORE = 60000;
    protected const STRAIGHT_SCORE = 50000;
    protected const THREE_OF_A_KIND_SCORE = 40000;
    protected const TWO_PAIR_SCORE = 30000;
    protected const PAIR_SCORE = 20000;

    protected array $order = [
        'A', '2', '3', '4', '5', '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'
    ];
    protected array $ranking = [
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

}