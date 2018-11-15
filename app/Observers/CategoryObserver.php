<?php

namespace App\Observers;

use App\Category;

class CategoryObserver
{
    /**
     * Handle the channel "creating" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function creating(Category $category)
    {
        $category->slug = str_slug($category->name);
    }

    /**
     * Handle the channel "updating" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function updating(Category $category)
    {
        $category->slug = str_slug($category->name);
    }
}
