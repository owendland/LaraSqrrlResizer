<?php
/**
 * ImageServiceProvider.php
 *
 * @company StitchLabs
 * @project horizon-demo
 *
 * @author  owendland
 */

namespace App\Image\Providers;

use App\Image\Repositories\ImageRepository;
use App\Image\Repositories\Implementations\DbImageRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class ImageServiceProvider
 *
 * @package App\Image\Providers
 */
class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ImageRepository::class,
            DbImageRepository::class
        );
    }
}