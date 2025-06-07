<?php
namespace Src\Model;
class estatistica {
    public $count;
    public $sum;
    public $avg;
    public $sumTx;
    public $avgTx;

    public function __construct($count = 0, $sum = 0, $avg = 0, $sumTx = 0, $avgTx = 0) {
        $this->count = $count;
        $this->sum = $sum;
        $this->avg = $avg;
        $this->sumTx = $sumTx;
        $this->avgTx = $avgTx;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count): void
    {
        $this->count = $count;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function setSum($sum): void
    {
        $this->sum = $sum;
    }

    public function getAvg()
    {
        return $this->avg;
    }

    public function setAvg($avg): void
    {
        $this->avg = $avg;
    }

    public function getSumTx()
    {
        return $this->sumTx;
    }

    public function setSumTx($sumTx): void
    {
        $this->sumTx = $sumTx;
    }

    public function getAvgTx()
    {
        return $this->avgTx;
    }

    public function setAvgTx($avgTx): void
    {
        $this->avgTx = $avgTx;
    }



    public function toArray() {
        return [
            "count" => $this->count,
            "sum" => round($this->sum, 2),
            "avg" => round($this->avg, 2),
            "sumTx" => round($this->sumTx, 2),
            "avgTx" => round($this->avgTx, 2)
        ];
    }
}
