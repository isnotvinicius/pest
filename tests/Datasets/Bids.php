<?php

dataset('bids', function(){
    $auction = new \App\Models\Auction('Car');

    $user1 = new \App\Models\User('User1');
    $user2 = new \App\Models\User('User2');
    $user3 = new \App\Models\User('User3');

    $auction->submitBid(new \App\Models\Bid($user3, 1700));
    $auction->submitBid(new \App\Models\Bid($user1, 2000));
    $auction->submitBid(new \App\Models\Bid($user2, 2500));

    yield $auction;
});
