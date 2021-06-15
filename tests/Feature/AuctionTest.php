<?php

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;

beforeEach(function(){
    $this->auction = new Auction('Car');
});

test('auction should not receive repeated bids', function(){
    $user = new User('User');
    $this->auction->submitBid(new Bid($user, 1000));

    expect($this->auction->getBids())->toHaveCount(1);
    expect($this->auction->getBids()[0]->getValue())->toEqual(1000);
});

test('auction should not receive more than 5 bids per user', function(){
    $user1 = new User('User1');
    $user2 = new User('User2');

    $this->auction->submitBid(new Bid($user1, 1000));
    $this->auction->submitBid(new Bid($user2, 1500));

    $this->auction->submitBid(new Bid($user1, 2000));
    $this->auction->submitBid(new Bid($user2, 2500));

    $this->auction->submitBid(new Bid($user1, 3000));
    $this->auction->submitBid(new Bid($user2,3500));

    $this->auction->submitBid(new Bid($user1, 4000));
    $this->auction->submitBid(new Bid($user2, 4500));

    $this->auction->submitBid(new Bid($user1, 5000));
    $this->auction->submitBid(new Bid($user2, 5500));

    $this->auction->submitBid(new Bid($user1, 6000));
})->throws(\DomainException::class, "User can't bid more than 5 times per auction");
