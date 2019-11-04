<?php

namespace Daguilarm\Belich\App\Http\Controllers\Traits;

use Daguilarm\Belich\Facades\Belich;
use Illuminate\Http\RedirectResponse;

trait Redirectable
{
    /**
     * Redirect back with message
     *
     * @param bool $condition
     * @param string $success
     * @param string $error
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToAction(bool $condition, string $success, string $error, string $id = ''): RedirectResponse
    {
        //Get current Controller action
        $action = Belich::action();
        //Get the redirection action
        $redirectTo = Belich::redirectTo();
        //Creating the redirection
        $redirect = $this->setRedirection($action, $redirectTo, $id);

        return $condition
            //As array or will fail...
            //The resource has been successfuly :action
            ? $redirect
                ->withMessageHeader(trans('belich::messages.crud.success.title'))
                ->withSuccess([trans('belich::messages.crud.success.text', ['action' => $success])])
            //Is array by default so no need...
            //An error occurred during the :action process
            : $redirect
                ->withMessageHeader(trans('belich::messages.crud.fail.title'))
                ->withErrors(trans('belich::messages.crud.fail.text', ['action' => $error, 'email' => config('mail.from.address')]));
    }

    /**
     * Set the redirection base on action
     *
     * @param string $action
     * @param string $redirectTo
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function setRedirection(string $action, string $redirectTo, string $id = ''): RedirectResponse
    {
        return !in_array($redirectTo, Belich::allowedActions()) || $action === 'delete' || $action === 'forceDelete' || $action === 'restore'
            //Action not allowed
            ? redirect()->back()
            //Allowed action and redirect to action
            : redirect()->to(Belich::actionRoute($redirectTo, $id));
    }
}
