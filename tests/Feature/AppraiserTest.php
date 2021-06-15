<?php

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Services\AppraiserService;

beforeEach(function(){
    $this->appraiser = new AppraiserService();
});

test('appraiser should find the highest bid', function($auction){
    $this->appraiser->appraise($auction);
    $highestValue = $this->appraiser->getHighestValue();
    expect($highestValue)->toEqual(2500);
})->with('bids');

test('appraiser should find the smaller bid', function($auction){
    $this->appraiser->appraise($auction);
    $smallerValue = $this->appraiser->getSmallerValue();
    expect($smallerValue)->toEqual(1700);
})->with('bids');

test('empty auction cannot be appraised', function(){
   $auction = new Auction('Car');
   $this->appraiser->appraise($auction);
})->throws(DomainException::class, "You can't appraise an auction without bids");

test('finished auction cannot be appraised', function(){
   $auction = new Auction('House');
   $auction->submitBid(new Bid(new User('User'), 2000));
   $auction->finish();
   $this->appraiser->appraise($auction);
})->throws(\DomainException::class, 'This auction has ended');
