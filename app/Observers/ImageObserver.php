<?php

namespace App\Observers;

use App\Image;
use App\Jobs\DeleteImage;

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
            DeleteImage::dispatch($oldUrl);
        }
    }

}
