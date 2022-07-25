<?php
 
namespace App\View\Composers;
 
use App\Models\User;
use Illuminate\View\View;
 
class ProfileComposer
{ 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('count', User::count());
    }
}