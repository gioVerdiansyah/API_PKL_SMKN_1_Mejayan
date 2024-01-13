<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;

class PengurusPklExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $model = new Guru();
        $columns = $model->getTableColumns();
        return collect([$columns]);
    }
}
