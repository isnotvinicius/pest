<?php

namespace App\Models;

class Auction
{
    private $bids;
    private $description;
    private $finished;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->bids = [];
        $this->finished = false;
    }

    public function submitBid(Bid $bid)
    {
        if(!empty($this->bids) && $this->belongsToLastUser($bid)){
            return;
        }

        $maxBidsPerUser = $this->totalBidsPerUser($bid->getUser());

        if($maxBidsPerUser >= 5){
            throw new \DomainException("User can't bid more than 5 times per auction");
        }

        $this->bids[] = $bid;
    }

    public function getBids(): array
    {
        return $this->bids;
    }

    public function finish()
    {
        $this->finished = true;
    }

    private function belongsToLastUser(Bid $bid): bool
    {
        $lastBid = $this->bids[count($this->bids) - 1];
        return $bid->getUser() == $lastBid;
    }

    private function totalBidsPerUser(User $user): int
    {
        return array_reduce($this->bids, function (int $totalValue, Bid $currentBid) use ($user) {
            if ($currentBid->getUser() == $user) {
                return $totalValue + 1;
            }
            return $totalValue;
        }, 0);
    }

    public function isFinished()
    {
        return $this->finished;
    }
}
