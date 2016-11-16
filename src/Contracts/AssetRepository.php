<?php

/**
 * Canalaiz\Sam\Contracts\AssetRepository
 *
 * @link      https://github.com/canalaiz/sam
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Contracts;

interface AssetRepository {

    /**
     * Retrieves all assets within singleton
     *
     * @return mixed
     */
    public function all();

    /**
     * Adds a new asset in the singleton
     *
     * @param string $type
     * @param string $position
     * @param string $url
     * @return mixed
     */
    public function push($type, $position, $url);
}
