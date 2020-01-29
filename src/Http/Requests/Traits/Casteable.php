<?php

namespace Daguilarm\Belich\Http\Requests\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

// This trait is inspired by https://github.com/stahiralijan/request-caster/
trait Casteable
{
    /**
     * Called by validate() method, it maps all the methods used to perform the operations
     *
     * @return void
     */
    public function mapCasts(): void
    {
        collect($this->request->get('cast'))
            ->each(function ($value): void {
                //Get cast and attribute
                [$cast, $attribute] = explode('|', $value);

                Str::startsWith($cast, 'date:')
                    // Cast to Date
                    ? $this->toDate($cast, $attribute)
                    // Cast using the method name
                    : $this->toMethod($attribute, $cast);
            });
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (): void {
            $this->mapCasts();
        });
    }

    /**
     * Execute a cast method
     *
     * @param string $attribute
     * @param string $cast
     *
     * @return void
     */
    protected function toMethod(string $attribute, string $cast): void
    {
        //Get method
        $method = sprintf('to%s', ucfirst($cast));

        //Do the magic...
        if (method_exists($this, $method)) {
            $this->{$method}($attribute);
        }
    }

    /**
     * Converts the request field into boolean using simple casting (bool)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toBoolean(string $key): void
    {
        if (in_array(request($key), ['true', 'false', '1', '0', 1, 0])) {
            $this->request->set($key, (bool) request($key));
        }
    }

    /**
     * Converts the request field into data using Carbon (date)
     * Format: date|format
     *
     * @param string $key
     *
     * @return void
     */
    protected function toDate(string $cast, string $key): void
    {
        //Get the format
        $format = explode(':', $cast)[1];
        $date = Carbon::createFromFormat($format, request($key));

        $this->request->set($key, $date);
    }

    /**
     * Converts the request field into an integer using simple casting (int)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toInteger(string $key): void
    {
        $this->request->set($key, (int) request($key));
    }

    /**
     * Converts the request field into floating-point value using simple casting (float)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toFloat(string $key): void
    {
        $this->request->set($key, (float) request($key));
    }

    /**
     * Converts JSON to an associated array using jscon_decode (json)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toJson(string $key): void
    {
        $this->request->set($key, json_decode(request($key)));
    }

    /**
     * Converts the request field into an string using simple casting (string)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toString(string $key): void
    {
        $this->request->set($key, (string) request($key));
    }

    /**
     * Converts the request field into a Carbon object (year)
     *
     * @param string $key
     *
     * @return void
     */
    protected function toYear(string $key): void
    {
        $this->request->set($key, Carbon::createFromFormat('Y', request($key))->year);
    }

    /**
     * Converts the request field into a Hash value
     *
     * @param string $key
     *
     * @return void
     */
    protected function toHash(string $key): void
    {
        $this->request->set($key, bcrypt(request($key)));
    }
}
