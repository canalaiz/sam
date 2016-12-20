<?php

/**
 * Canalaiz\Sam\Repositories\ArrayAssetRepository.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Repositories;

use Canalaiz\Sam\Contracts;
use Canalaiz\Sam\Entities\Asset;

class ArrayAssetRepository implements Contracts\AssetRepository
{
    private $array = [];

    public function all()
    {
        return $this->array;
    }

    public function push($type, $position, $src, $minify = false)
    {
        $asset = new Asset();

        $asset->type = $type;
        $asset->position = $position;
        $asset->src = $src;
        $asset->minify = $minify;

        $this->array[] = $asset;

        return $this;
    }
}
