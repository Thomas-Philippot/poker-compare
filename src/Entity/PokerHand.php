<?php

namespace App\Entity;

use App\Exception\InvalidCardListException;
use phpDocumentor\Reflection\Types\This;

class PokerHand
{

    /**
     * @var Card[]
     */
    private array $cards;

    /**
     * @param string $cardList
     * @throws InvalidCardListException
     */
    public function __construct(string $cardList)
    {
        $pattern = '/^([23456789TJQKA][SHDC] ){4}[23456789TJQKA][SHDC]$/';
        if (!preg_match($pattern, $cardList)) {
            throw new InvalidCardListException("Invalide card list");
        }

        $cards = explode(" ", $cardList);
        foreach ($cards as $card) {
            $value = $card[0];
            $suit = $card[1];
            $newCard = new Card($value, $suit);
            $this->cards[] = $newCard;
        }
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): PokerHand
    {
        $this->cards = $cards;
        return $this;
    }

    public function compareWith(PokerHand $hand): int
    {
        $playerRank = $this->getHandRank();
        $opponentRank = $hand->getHandRank();

        if ($playerRank > $opponentRank) {
            // WIN
            return 1;
        }

        if ($playerRank < $opponentRank) {
            // LOOSE
            return 2;
        }

        $playerScore = $this->getHandScore();
        $opponentScore = $hand->getHandScore();

        dump($playerScore);
        dump($opponentScore);
        if ($playerScore > $opponentScore) {
            // WIN
            return 1;
        }

        if ($playerScore < $opponentScore) {
            // LOOSE
            return 2;
        }
        // TODO : compare the rank of the hands
        // TIE
        return 3;
    }

    private function getHandRank(): int
    {
        $fromTenToAce = $this->isFromTenToAce();
        $isStraight = $this->isStraight();
        $sameSuit = $this->isSameSuit();
        $sameRank = $this->getSameRank();

        // ROYAL FLUSH
        if ($fromTenToAce && $sameSuit) {
            dump("ROYAL FLUSH");
            return 10;
        }

        // STRAIGHT FLUSH
        if ($isStraight && $sameSuit) {
            dump("STRAIGHT FLUSH");
            return 9;
        }

        // FOUR OF A KIND
        if (count($sameRank) > 0 && $sameRank[0] === 4) {
            dump("FOUR OF A KIND");
            return 8;
        }

        // FULL HOUSE
        if (count($sameRank) > 1 && $sameRank[0] === 2 && $sameRank[1] === 3) {
            dump("FULL HOUSE");
            return 7;
        }

        // FLUSH
        if ($sameSuit) {
            dump("FLUSH");
            return 6;
        }

        // STRAIGHT
        if ($isStraight) {
            dump("STRAIGHT");
            return 5;
        }

        // THREE OF A KIND
        if (count($sameRank) > 0 && $sameRank[0] === 3) {
            dump("THREE OF A KIND");
            return 4;
        }

        // TWO PAIR
        if (count($sameRank) > 1 && $sameRank[0] === 2 && $sameRank[1] === 2) {
            dump("two pair");
            return 7;
        }

        // PAIR
        if (count($sameRank) > 0 && $sameRank[0] === 2) {
            dump("pair");
            return 2;
        }

        return 1;
    }

    private function getHandScore(): int
    {
        $score = 0;
        foreach ($this->cards as $card) {
            $score += $card->getRank();
        }
        return $score;
    }

    private function getSameRank(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $results = [];
        foreach (array_count_values($values) as $count) {
            if ($count >= 2) {
                $results[] = $count;
            }
        }
        sort($results);
        return $results;
    }

    private function isSameSuit(): bool
    {
        $suit = $this->cards[0]->getSuit();
        foreach ($this->cards as $card) {
            if ($suit !== $card->getSuit()) {
                return false;
            }
        }
        return true;
    }

    private function isStraight(): bool
    {
        // TODO : vérifier que la suite puisse finir ou commencé par A
        $prev = null;
        foreach ($this->cards as $card) {
            if ($prev !== null && $card->getRank() !== $prev - 1) {
                return false;
            }
            $prev = $card->getRank();

        }
        return true;
    }

    private function isFromTenToAce(): bool
    {
        $total = 0;
        foreach ($this->cards as $card) {
            $total += $card->getRank();
        }
        return $total === 55;
    }
}