<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Product;

class ProductImport implements ToModel, WithChunkReading,ShouldQueue
{
    /**
    * @param Collection $collection
    */

    public function model(array $row)
    {
        
       return new Product([
            'ItemBarcode' => $row[0],
            'ItemCode' => $row[1],
            'ItemName' => $row[2],
            'ItemPrice' => $row[3],
            'vendor' => $row[4],
        ]);
      
      
    }
    public function chunkSize(): int
    {
        return 5000;
    }
}
