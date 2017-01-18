<?php

/**
 * Canalaiz\Sam\Infrastructure\StringHtmlInjectEngine.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Infrastructure;

use Canalaiz\Sam\Contracts\HtmlInjectEngine;

class StringHtmlInjectEngine implements HtmlInjectEngine
{
    /**
     * Processes html with Css type asset.
     *
     * @param string $html
     * @param Asset $asset
     *
     * @return string $html
     */
    public function injectCss($html, $asset)
    {
        if ($asset->inline) {
            return $this->injectString($html, '</head>', '<style type="text/css">' . $asset->src . '</style>');
        } 
        return $this->injectString($html, '</head>', '<link href="' . $asset->src . '" rel="stylesheet" type="text/css" />');
    }

    /**
     * Processes html with Javascript type asset.
     *
     * @param string $html
     * @param Asset $asset
     *
     * @return string $html
     */
    public function injectJs($html, $asset)
    {
        if ($asset->inline) {
            return $this->injectString($html, '</body>', '<script type="text/javascript" defer>' . $asset->src . '</script>');
        }
        
        return $this->injectString($html, '</body>', '<script src="' . $asset->src . '" type="text/javascript" defer></script>');
    }

    /**
     * Processes html with Placeholder type asset.
     *
     * @param string $html
     * @param Asset $asset
     *
     * @return string $html
     */
    public function injectPlaceholder($html, $asset)
    {
        return $this->injectString($html, '<!--' . $asset->position . '-->', $asset->src);
    }

    /**
     * Processes html with Tag type asset.
     *
     * @param string $html
     * @param Asset $asset
     *
     * @return string $html
     */
    public function injectTag($html, $asset)
    {
        return $this->injectString($html, '</' . $asset->position . '>', $asset->src);
    }
  
    /**
     * Prepends a string before a specific needle in html.
     *
     * @param string $html
     * @param string $needle
     * @param string $prepend
     *
     * @return string $html
     */    
    private function injectString($html, $needle, $prepend)
    {
        $position = stripos($html, $needle);
        if ($position !== false) { return substr($html, 0, $position) . $prepend . substr($html, $position); }
        
        return $html;
    }
}