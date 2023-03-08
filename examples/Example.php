<?php

class Example
{
    public function foo()
    {
        $replicate = new \Mazin\Replicate\Replicate('token');
        $replicate->createPrediction();
    }
}