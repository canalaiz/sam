<?php

/**
 * Canalaiz\Sam\Infrastructure\Sam.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Infrastructure;

use Canalaiz\Sam\Contracts\AssetRepository;
use Canalaiz\Sam\Contracts\HtmlInjectEngine;
use Canalaiz\Sam\Enums;

class Sam
{
    /**
     * The Asset Repository instance.
     *
     * @var Canalaiz\Sam\Contracts\AssetRepository
     */
    protected $AssetRepository;

    /**
     * The HtmlInjectEngine instance.
     *
     * @var Canalaiz\Sam\Contracts\HtmlInjectEngine
     */
    protected $HtmlInjectEngine;

    /**
     * Create a new Cache manager instance.
     *
     * @param \Canalaiz\Sam\Contracts\AssetRepository $AssetRepository
     *
     * @return void
     */
    public function __construct(AssetRepository $AssetRepository, HtmlInjectEngine $HtmlInjectEngine)
    {
        $this->AssetRepository = $AssetRepository;
        $this->HtmlInjectEngine = $HtmlInjectEngine;
    }

    /**
     * Pushes Javascript asset into repository.
     *
     * @param string $url
     *
     * @return void
     */
    public function pushJs($url, $minify = true)
    {
        $this->AssetRepository->push(Enums\Type::JS, Enums\Position::BODY, $url, $minify);
    }

    /**
     * Pushes Css asset into repository.
     *
     * @param string $url
     *
     * @return void
     */
    public function pushCss($url, $minify = true)
    {
        $this->AssetRepository->push(Enums\Type::CSS, Enums\Position::HEAD, $url, $minify);
    }
    
    /**
     * Pushes Javascript asset into repository.
     *
     * @param string $url
     *
     * @return void
     */
    public function pushInlineJs($url, $minify = true)
    {
        $this->AssetRepository->push(Enums\Type::INLINEJS, Enums\Position::BODY, $url, $minify);
    }

    /**
     * Pushes Css asset into repository.
     *
     * @param string $url
     *
     * @return void
     */
    public function pushInlineCss($url, $minify = true)
    {
        $this->AssetRepository->push(Enums\Type::INLINECSS, Enums\Position::HEAD, $url, $minify);
    }

    /**
     * Pushes Tag asset into repository.
     *
     * @param string $html
     *
     * @return void
     */
    public function pushTag($tag, $html)
    {
        $this->AssetRepository->push(Enums\Type::TAG, $tag, $html, false);
    }

    /**
     * Pushes Placeholder asset into repository.
     *
     * @param string $placeholder
     * @param string $html
     *
     * @return void
     */
    public function pushPlaceholder($placeholder, $html)
    {
        $this->AssetRepository->push(Enums\Type::PLACEHOLDER, $placeholder, $html, false);
    }

    /**
     * Processes html with pushed assets.
     *
     * @param string $html
     *
     * @throws \InvalidArgumentException
     *
     * @return string $html
     */
    public function process($html)
    {
        collect($this->AssetRepository->all())->each(function ($asset) use (&$html) {
            $injectMethod = 'inject' . ucfirst($asset->type);
            if (method_exists($this->HtmlInjectEngine, $injectMethod)) {
                $html = $this->HtmlInjectEngine->{$injectMethod}($html, $asset);
            } else {
                throw new \InvalidArgumentException("Inject [{$asset->type}] is not supported.");
            }
        });

        return $html;
    }
}
