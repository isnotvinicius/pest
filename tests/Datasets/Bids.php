<?php

dataset('bids', function(){
    $auctionCrescentOrder = new \App\Models\Auction('Car');

    $user1 = new \App\Models\User('User1');
    $user2 = new \App\Models\User('User2');
    $user3 = new \App\Models\User('User3');

    $auctionCrescentOrder->submitBid(new \App\Models\Bid($user3, 1700));
    $auctionCrescentOrder->submitBid(new \App\Models\Bid($user1, 2000));
    $auctionCrescentOrder->submitBid(new \App\Models\Bid($user2, 2500));

    $auctionDecrementOrder = new \App\Models\Auction('House');

    $auctionDecrementOrder->submitBid(new \App\Models\Bid($user3, 2500));
    $auctionDecrementOrder->submitBid(new \App\Models\Bid($user1, 2000));
    $auctionDecrementOrder->submitBid(new \App\Models\Bid($user2, 1700));

    yield $auctionCrescentOrder;
    yield $auctionDecrementOrder;
});
