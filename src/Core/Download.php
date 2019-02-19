<?php

namespace Daguilarm\Belich\Core;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class Download implements FromCollection
{
    private $model;
    private $request;

    public function __construct($model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    public function collection()
    {
        return $this->model->all();
    }
}
