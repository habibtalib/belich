<?php

namespace Daguilarm\Belich\Core;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class Download implements FromCollection
{
    private $model;
    private $request;
    private $selected;

    /**
     * Init constructor
     *
     * @param object $model
     * @param \Illuminate\Http\request $request
     */
    public function __construct(object $model, Request $request)
    {
        $this->model    = $model;
        $this->request  = $request;
        $this->selected = $request->exports_selected;
    }

    /**
     * Get collection from model
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function collection() : Collection
    {
        //Selected fields
        if($this->request->quantity === 'selected') {
            return $this->model
                //App\Http\Helpers\Utils
                ->whereIn('id', fieldToArray($this->selected))
                ->get();
        }

        //All the fields
        return $this->model->all();
    }
}
