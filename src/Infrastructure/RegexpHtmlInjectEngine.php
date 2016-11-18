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
        return preg_replace('/(<\/BODY>)/i', '<script src="'.$asset->src.'" type="text/javascript" defer></script>'.'$1', $html);
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
}
