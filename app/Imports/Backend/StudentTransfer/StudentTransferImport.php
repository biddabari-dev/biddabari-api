<?php

namespace App\Imports\Backend\StudentTransfer;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentTransferImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return $collection;
//        $mobileArray = [];
//        foreach ($collection as $row)
//        {
//            array_push($mobileArray, $row[0]);
//        }
//        return $mobileArray;
    }
}
