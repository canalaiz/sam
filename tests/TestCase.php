<?php

/**
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */
abstract class TestCase extends Orchestra\Testbench\TestCase
{
    protected $html;

    protected function setUp()
    {
        parent::setUp();

        $this->html = '<html><head></head><body><!--PLACEHOLDER--></body></html>';
    }

    protected function getPackageProviders($app)
    {
        return ['Canalaiz\Sam\SamServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Sam' => 'Canalaiz\Sam\Facades\Sam',
        ];
    }
}
