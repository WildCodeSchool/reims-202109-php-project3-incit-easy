<?php

namespace App\Service;

class GarbageManager
{
    public function getDataSample(): string
    {
        return (string)file_get_contents("./src/Service/data.csv");
    }
}
