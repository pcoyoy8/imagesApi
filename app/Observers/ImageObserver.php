<?php

namespace App\Observers;

use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * Handle the image "updated" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function updated(Image $image)
    {
        $oldUrl = $image->getOriginal('download_url');

        if ($oldUrl)
        {
            Storage::disk('public')
                ->delete($oldUrl['reference']);
        }
    }

}
