<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function getColumn(){
        $model = new Dudi();
        $columns = $model->getTableColumns();
        dump($columns);
    }
}
