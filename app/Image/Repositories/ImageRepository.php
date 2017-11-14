<?php
/**
 * ImageRepository.php
 *
 * @project horizon-demo
 *
 * @author  owendland
 */

namespace App\Image\Repositories;

use App\Image;

/**
 * Interface ImageRepository
 *
 * @package App\Image\Repositories
 */
interface ImageRepository
{
    /**
     * @param string      $source_url
     * @param string|null $name
     *
     * @return \App\Image
     */
    public function persist(string $source_url, string $name = null): Image;
}