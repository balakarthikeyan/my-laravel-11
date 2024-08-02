<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\JsonResponse;

interface TestInterface
{
    public function testInferfaceMethod(): JsonResponse;
}
