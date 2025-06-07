<?php
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
