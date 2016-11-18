<?php

/**
 * Canalaiz\Sam\Contracts\HtmlInjectEngine.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */
namespace Canalaiz\Sam\Contracts;

interface HtmlInjectEngine
{
    /**
     * Processes html with Css type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectCss($html, $asset);

    /**
     * Processes html with Javascript type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectJs($html, $asset);

    /**
     * Processes html with Placeholder type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectPlaceholder($html, $asset);

    /**
     * Processes html with Tag type asset.
     *
     * @param string $html
     *
     * @return string $html
     */
    public function injectTag($html, $asset);
}
