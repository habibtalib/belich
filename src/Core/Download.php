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
        // Selected fields
        if($this->request->quantity === 'selected') {
            return $this->model
                ->whereIn('id', $this->filterValues())
                ->get();
        }

        // All the fields
        return $this->model->all();
    }

    /**
     * filter the values: only numeric values
     *
     * @return array
     */
    public function filterValues() : array
    {
        return collect(explode(',', $this->selected))
            ->map(function($value) {
                // Only numeric values
                if(!empty($value) && is_numeric($value)) {
                    return (integer) $value;
                }
            })
            ->filter()
            ->toArray();
    }
}
