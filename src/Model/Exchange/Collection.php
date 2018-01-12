<?php namespace App\Model\Exchange;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
    public function getAmount()
    {
        $amount = 0;
        foreach ($this->getIterator() as $item) {
            $amount += $item->getAmount();
        }
        return $amount;
    }
}