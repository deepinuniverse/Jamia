<?php

namespace App\Imports;
use Illuminate\Http\Request;
use App\Models\FamilyCardData;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
class UserImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */




    public function collection(Collection $rows)
    {
            foreach($rows as $row)
            {
                
                
                

                    $familycard =  FamilyCardData::updateOrCreate(
                        [
                            'CIVIL_ID' => $row['civil_id'],
                            'CODE' => $row['code'],
                        ],
                        [
                            'CARD_NO' => $row['card_no'],
                            'NAME' => $row['name'],
                            'SHR_NO' => $row['shr_no'],
                            'PROFIT' => $row['profit'],
                            'sex' => $row['sex'],
                            'start_date' => $row['start_date'],
                           
                        ]);
                                    
                                    

                            
                
            }
   
}

}










         
           
          
               
         