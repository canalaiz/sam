<?php

/**
 * Canalaiz\Sam\Repositories\ArrayAssetRepository
 *
 * @link      https://github.com/canalaiz/sam
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Repositories;

use Canalaiz\Sam\Contracts;
use Canalaiz\Sam\Entities\Asset;

class ArrayAssetRepository Implements Contracts\AssetRepository {

    private $array = [];

    public function all() {
        return $this->array;
    }

    public function push($type, $position, $src) {
        $asset = new Asset();

        $asset->type = $type;
        $asset->position = $position;
        $asset->src = $src;

        $this->array[] = $asset;

        return $this;
    }

}
