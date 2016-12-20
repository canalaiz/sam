<?php

/**
 * Canalaiz\Sam\Infrastructure\RegexpHtmlInjectEngine.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Infrastructure;

use Canalaiz\Sam\Contracts\HtmlInjectEngine;
use Canalaiz\Sam\Enums;
use Cache;

class RegexpHtmlInjectEngine implements HtmlInjectEngine
{
    /**
     * Processes html with Css type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectCss($html, $asset)
    {
        if ($asset->minify === true) {
            $asset = $this->resourceToAsset($asset);
        }
        return preg_replace('/(<\/HEAD>)/i', '<link href="'.$asset->src.'" rel="stylesheet" type="text/css" />'.'$1', $html);
    }
    
    /**
     * Processes html with Javascript type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectJs($html, $asset)
    {
        if ($asset->minify == true) {
            $asset = $this->resourceToAsset($asset);
        }
        return preg_replace('/(<\/BODY>)/i', '<script src="'.$asset->src.'" type="text/javascript" defer></script>'.'$1', $html);
    }
    
    /**
     * Processes html with Css Inline type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectInlineCss($html, $asset)
    {
        return preg_replace('/(<\/HEAD>)/i', '<style type="text/css" url="' . $asset->src . '">' . $this->resourceToAsset($asset)->src . '</style>'.'$1', $html);
    }

    /**
     * Processes html with Javascript Inline type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectInlineJs($html, $asset)
    {
        return preg_replace('/(<\/BODY>)/i', '<script url="'.$asset->src.'" type="text/javascript" defer>' . $this->resourceToAsset($asset)->src . '</script>'.'$1', $html);
    }

    /**
     * Processes html with Placeholder type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectPlaceholder($html, $asset)
    {
        return preg_replace('/(<!--'.$asset->position.'-->)/i', $asset->src.'$1', $html);
    }

    /**
     * Processes html with Tag type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectTag($html, $asset)
    {
        return preg_replace('/(<\/'.$asset->position.'>)/i', $asset->src.'$1', $html);
    }
    
    private function resourceToAsset($asset) 
    {
        $asset = Cache::remember($asset->src, 60 * 24 * 7, function () use($asset) {
            $client = new \GuzzleHttp\Client();
            try {
                $request = $client->request('GET', $asset->src);
                
                if ($request->getBody() != '') {
                    $resource = $request->getBody();
                } else {
                    $resource = '/* resource responded with status ' . $request->getStatus() .' */';
                }
                
                $filename = public_path(str_slug($asset->src));
                if ($asset->type == Enums\Type::JS || $asset->type == Enums\Type::INLINEJS) {
                    $minifier = new \MatthiasMullie\Minify\JS();
                    $filename .=  '.js';
                } else {
                    $minifier = new \MatthiasMullie\Minify\CSS();
                    $filename .=  '.css';
                }
                $minifier->add($resource);
                $minifier->minify($filename);

                if ($asset->type == Enums\Type::INLINEJS || $asset->type == Enums\Type::INLINECSS) {
                    $asset->src = $minifier->minify();
                } else {
                    $asset->src = asset($filename);                
                }
            } catch(\Exception $e) {
                $asset->src = '/* failed request with exception ' . $e->getMessage() . ' */';
            }
            return $asset;
        });
        
        return $asset;
    }
}
