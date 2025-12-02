<?php

namespace App\Exports;

use App\Models\Platillo;
use Maatwebsite\Excel\Concerns\FromCollection;

class PlatillosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Platillo::all();
    }
}
