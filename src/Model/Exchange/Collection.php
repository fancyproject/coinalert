<?php namespace App\Model\Exchange;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
    /** @var float */
    protected $invested;

    /**
     * @return int
     */
    public function getAmount()
    {
        $amount = 0;
        foreach ($this->getIterator() as $item) {
            $amount += $item->getAmount();
        }
        return $amount;
    }

    /**
     * @return float
     */
    public function getPercent()
    {
        return $this->getAmount() * 100 / $this->getInvested();
    }

    /**
     * @return int
     */
    public function getEarn()
    {
        return $this->getAmount() - $this->getInvested();
    }

    /**
     * @return float
     */
    public function getInvested(): float
    {
        return $this->invested;
    }

    /**
     * @param float $invested
     * @return $this
     */
    public function setInvested(float $invested)
    {
        $this->invested = $invested;
        return $this;
    }
}
