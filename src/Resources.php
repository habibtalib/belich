<?php

namespace Daguilarm\Belich;

abstract class Resources {

    /**
     * The resource settings
     *
     * @var Illuminate\Support\Collection
     */
    protected $settings;

    /**
     * The model object
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The breadcrumb
     *
     * @var Illuminate\Support\Collection
     */
    protected $breadcrumb;

    /**
     * The actions
     *
     * @var Illuminate\Support\Collection
     */
    protected $actions;

    /**
     * The metrics
     *
     * @var Illuminate\Support\Collection
     */
    protected $metrics;

    /**
     * The cards
     *
     * @var Illuminate\Support\Collection
     */
    protected $cards;

    /**
     * The fields
     *
     * @var Illuminate\Support\Collection
     */
    protected $fields;

    /**
     * Create a new resource instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = collect($this->settings);
        $this->model = $this->settings->get('model')::with($this->settings->get('relationships'));
    }

    /**
     * Get the storage data for a given resource.
     *
     * @param  int  $id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }
}
