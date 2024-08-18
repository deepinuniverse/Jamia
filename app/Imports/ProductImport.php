<?php

namespace App\Imports;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    public function collection(Collection $rows)
    {
      foreach($rows as $row)
      {
        
                   
        
                            $products =  Product::create(
                           
                            [
                                'ItemName' => $row['name'],
                                'ItemPrice' => $row['price'],
                                'ItemBarcode' => $row['barcode'],
                                'ItemCode' => $row['code'],
                               
                                
                                
        
                            ]);
                            

                    
           
        }
   
    }
}
