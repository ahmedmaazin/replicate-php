<?php

namespace Mazin\Replicate;

class Replicate
{
    private array $headers;

    public function __construct(private readonly string $token)
    {
        $this->headers = ['Authorization' => $token];
    }

    public function models()
    {
    }

    public function model()
    {
    }

    public function modelVersions()
    {
    }

    public function deleteModelVersion()
    {
    }

    public function modelVersion()
    {
    }

    public function predictions()
    {
    }

    public function createPrediction()
    {
    }

    public function prediction()
    {
    }

    public function cancelPrediction()
    {
    }
}
