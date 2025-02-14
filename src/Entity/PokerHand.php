<?php

namespace App\Entity;

use App\Exception\InvalidCardListException;

class PokerHand extends AbstractPokerRules
{

    /**
     * @var PokerCard[]
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
            $newCard = new PokerCard($value, $suit);
            $this->cards[] = $newCard;
        }
        $this->orderCards();
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
        $playerScore = $this->getScore();
        $opponentScore = $hand->getScore();

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
        // TIE
        return 3;
    }

    private function orderCards(): void
    {
        usort($this->cards, static function (PokerCard $a, PokerCard $b) {
            return $a->getRank() - $b->getRank();
        });

        // if hand is 2, 3, 4 and 5, hands needs to be sorted with A first
        if ($this->totalRankEquals(23)) {
            usort($this->cards, function (PokerCard $a, PokerCard $b) {
                return array_search($a->getValue(), $this->order, true) - array_search($b->getValue(), $this->order, true);
            });
        }
    }

    private function getScore(): int
    {
        $fromTenToAce = $this->totalRankEquals(55);
        $isStraight = $this->isStraight();
        $sameSuit = $this->isSameSuit();
        $duplicates = $this->getDuplicates();

        // ROYAL FLUSH
        if ($fromTenToAce && $sameSuit) {
            dump("ROYAL FLUSH");
            return 1000;
        }

        // STRAIGHT FLUSH
        if ($isStraight && $sameSuit) {
            dump("STRAIGHT FLUSH");
            return 900;
        }

        // FOUR OF A KIND
        if (count($duplicates) > 0 && $duplicates[0]['count'] === 4) {
            dump("FOUR OF A KIND");
            return 800 + $this->getKickerScore($duplicates);
        }

        // FULL HOUSE
        if (count($duplicates) > 1 && $duplicates[0]['count'] === 2 && $duplicates[1]['count'] === 3) {
            dump("FULL HOUSE");
            return 700;
        }

        // FLUSH
        if ($sameSuit) {
            dump("FLUSH");
            return 600;
        }

        // STRAIGHT
        if ($isStraight) {
            dump("STRAIGHT");
            return 500;
        }

        // THREE OF A KIND
        if (count($duplicates) > 0 && $duplicates[0]['count'] === 3) {
            dump("THREE OF A KIND");
            return 400 + $this->getDuplicatesScore($duplicates) + $this->getKickerScore($duplicates);
        }

        // TWO PAIR
        if (count($duplicates) > 1 && $duplicates[0]['count'] === 2 && $duplicates[1]['count'] === 2) {
            dump("two pair");
            return 300 + $this->getDuplicatesScore($duplicates) + $this->getKickerScore($duplicates);
        }

        // PAIR
        if (count($duplicates) > 0 && $duplicates[0]['count'] === 2) {
            dump("pair");
            return 200 + $this->getDuplicatesScore($duplicates) + $this->getKickerScore($duplicates);
        }

        return $this->getHandScore();
    }

    private function getHandScore(): int
    {
        $score = 0;
        foreach ($this->cards as $card) {
            $score += $card->getRank();
        }
        return $score;
    }

    private function getDuplicatesScore(array $duplicates): int
    {
        $score = 0;
        foreach ($duplicates as $card) {
            $score += $this->ranking[$card['value']];
        }
        return $score;
    }

    private function getKickerScore(array $duplicates): int
    {
        $values = [];
        foreach ($this->cards as $card) {
            if (
                $card->getValue() === $duplicates[0]['value'] ||
                (count($duplicates) > 1 && $card->getValue() === $duplicates[1]['value'])
            ) {
                continue;
            }
            $values[] = $card->getValue();
        }

        $score = 0;
        foreach ($values as $value) {
            $score += $this->ranking[$value];
        }
        return $score;
    }

    private function getDuplicates(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card->getValue();
        }
        $results = [];
        foreach (array_count_values($values) as $value => $count) {
            if ($count >= 2) {
                $results[] = ['value' => (string) $value, 'count' => $count];
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
        $prevIndex = null;
        foreach ($this->cards as $card) {
            if ($prevIndex !== null && $card->getValue() !== $this->order[$prevIndex + 1]) {
                return false;
            }
            $prevIndex = array_search($card->getValue(), $this->order, true);

        }
        return true;
    }

    private function totalRankEquals(int $rank): bool
    {
        $total = 0;
        foreach ($this->cards as $card) {
            $total += $card->getRank();
        }
        return $total === $rank;
    }
}