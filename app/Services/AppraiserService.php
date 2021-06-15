<?php

namespace App\Services;

use App\Models\Bid;
use App\Models\Auction;

class AppraiserService
{
    private $highestValue = 0;
    private $smallerValue = INF;
    private $highestBids;

    public function appraise(Auction $auction): void
    {
        if($auction->isFinished()){
            throw new \DomainException('This auction has ended');
        }

        if(empty($auction->getBids())){
            throw new \DomainException("You can't appraise an auction without bids");
        }

        foreach($auction->getBids() as $bid){
            if($bid->getValue() > $this->highestValue){
                $this->highestValue = $bid->getValue();
            }

            if($bid->getValue() < $this->smallerValue){
                $this->smallerValue = $bid->getValue();
            }
        }

        $bids = $auction->getBids();

        usort($bids, function(Bid $bid1, Bid $bid2) {
            return $bid2->getValue() - $bid1->getValue();
        });

        $this->highestValues = array_slice($bids, 0, 3);
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }

    public function getSmallerValue(): float
    {
        return $this->smallerValue;
    }

    public function getHighestBids()
    {
        return $this->highestBids;
    }
}
