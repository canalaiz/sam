<?php

/**
 * Canalaiz\Sam\Entities\Asset.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Entities;

use Cache;
use Canalaiz\Sam\Enums;
use File;

class Asset
{
    /**
     * Type of asset.
     */
    public $type;

    /**
     * Position of asset.
     */
    public $position;

    /**
     * Url of the asset.
     */
    public $url;

    /**
     * Source of the asset.
     */
    public $src;

    /**
     * Flag if asset must be minified.
     */
    public $minify;

    /**
     * Flag if asset must be viewed inline.
     */
    public $inline;

    /**
     * Fetch remote asset.
     *
     * @return $this
     */
    public function fetch()
    {
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->request('GET', $this->url);

            if ($request->getBody() != '') {
                $this->src = $request->getBody();
            } else {
                $this->src = '/* resource responded with status '.$request->getStatus().' */';
            }
        } catch (\Exception $e) {
            $this->src = '/* failed request with exception '.$e->getMessage().' */';
        }

        return $this;
    }

    /**
     * Store asset.
     *
     * @return $this
     */
    public function store()
    {
        $filename = public_path('sam_minified/'.str_slug($this->url).'.'.$this->type);
        if (!file_exists($filename)) {
            File::makeDirectory(public_path('sam_minified/'), 0775, true, true);
        }
        File::put($filename, $this->src);

        if ($this->inline === false) {
            $this->src = '//'.'sam_minified/'.(basename($filename));
        }
        Cache::put($this->type.$this->url, $this, 60 * 24 * 7);

        return $this;
    }

    /**
     * Minify asset.
     *
     * @return $this
     */
    public function minify()
    {
        if ($this->type == Enums\Type::JS) {
            $minifier = new \MatthiasMullie\Minify\JS();
        } else {
            $minifier = new \MatthiasMullie\Minify\CSS();
        }

        $minifier->add($this->src);
        $this->src = $minifier->minify();

        return $this;
    }

    /**
     * Converts current asset into usable.
     *
     * @return $this
     */
    public function convert()
    {
        if ($this->minify || $this->inline) {
            if (Cache::has($this->type.$this->url)) {
                return Cache::get($this->type.$this->url);
            }

            $this->fetch();

            if ($this->minify) {
                $this->minify();
            }

            $this->store();
        } else {
            $this->src = $this->url;
        }

        return $this;
    }
}
