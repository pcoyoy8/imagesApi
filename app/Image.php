<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'picture_title',
        'picture_url',
        'download_url',
        'picture_description'
    ];

    public function getDownloadUrlAttribute($value)
    {
        return Storage::disk('public')
            ->url($value);
    }
}
