<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Image
 *
 * @mixin \Eloquent
 * @property int                 $id
 * @property string              $name
 * @property string              $source_url
 * @property array               $resized_urls
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereResizedUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereSourceUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 */
class Image extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'resized_urls' => 'array',
    ];

    /**
     * The attributes that should be allowed for mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'source_url',
    ];
}
