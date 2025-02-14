Since no one remembers the card ranking you will have to write a program that
compare poker hands and determines a winner.

## 1. Task

A poker hand has a constructor that accepts a string containing 5 cards:

```
var hand = new PokerHand("KS 2H 5C JD TD");
```

and a method to compare itself to another hand

```
PokerHand.prototype.compareWith = function(hand) { /* Your code here */ };
```

The characteristics of the string of cards are:
* A space is used as card seperator
* Each card consists of two characters
* The first character is the value of the card, valid characters are: `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `T`(en), `J`(ack), `Q`(ueen), `K`(ing), `A`(ce)
* The second character represents the suit, valid characters are: `S`(pades), `H`(earts), `D`(iamonds), `C`(lubs)

The result of your poker hand compare can be one of these 3 options:
* Win should return the integer `1`
* Loss should return the integer `2`
* Tie should return the integer `3`

The ranking of the hands should follow the [Texas Hold'em rules](https://www.pokerlistings.com/poker-hand-ranking)

## 2. Requirements

All your code should be contained in the `src/` folder.

You must use PHP but you are free to architect your code the way you want.

You can use any libraries that you feel are relevant to solve this problem (except for the algorithm part).

Unit tests and UI are welcome.

/!\\ You need to include a markdown file that shows the steps required to run your demo

Good luck ;-)