<?php

/**
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */
class SamTest extends TestCase
{
    public function testNoPush()
    {
        $expected = $this->html;

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushCss()
    {
        $expected = '<html><head><link href="http://www.acme.com/style.css" rel="stylesheet" type="text/css" /></head><body><!--PLACEHOLDER--></body></html>';

        Sam::pushCss('http://www.acme.com/style.css');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushJs()
    {
        $expected = '<html><head></head><body><!--PLACEHOLDER--><script src="http://www.acme.com/script.js" type="text/javascript" defer></script></body></html>';

        Sam::pushJs('http://www.acme.com/script.js');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushPlaceholder()
    {
        $expected = '<html><head></head><body><div>Hello from Sam!</div><!--PLACEHOLDER--></body></html>';

        Sam::pushPlaceholder('PLACEHOLDER', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushPlaceholderCaseInsensitive()
    {
        $expected = '<html><head></head><body><div>Hello from Sam!</div><!--PLACEHOLDER--></body></html>';

        Sam::pushPlaceholder('PlAcEhOlDeR', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushPlaceholderNotFound()
    {
        $expected = '<html><head></head><body><!--PLACEHOLDER--></body></html>';

        Sam::pushPlaceholder('ANOTHER_PLACEHOLDER', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushTag()
    {
        $expected = '<html><head></head><body><!--PLACEHOLDER--><div>Hello from Sam!</div></body></html>';

        Sam::pushTag('body', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushTagCaseInsensitive()
    {
        $expected = '<html><head></head><body><!--PLACEHOLDER--><div>Hello from Sam!</div></body></html>';

        Sam::pushTag('BoDy', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }

    public function testPushTagNotFound()
    {
        $expected = '<html><head></head><body><!--PLACEHOLDER--></body></html>';

        Sam::pushTag('another_tag', '<div>Hello from Sam!</div>');

        $this->assertEquals($expected, Sam::process($this->html));
    }
    
    public function testPushCssMinify() {
        $expected = '<html><head><link href="//sam_minified/httpsmaxcdnbootstrapcdncombootstrap337cssbootstrapmincss.css" rel="stylesheet" type="text/css" /></head><body><!--PLACEHOLDER--></body></html>';
        
        Sam::pushCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', true);
        
        $this->assertEquals($expected, Sam::process($this->html));
    }
    
    public function testPushJsMinify() {
        $expected = '<html><head></head><body><!--PLACEHOLDER--><script src="//sam_minified/httpsmaxcdnbootstrapcdncombootstrap337jsbootstrapminjs.js" type="text/javascript" defer></script></body></html>';
        
        Sam::pushJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', true);
        
        $this->assertEquals($expected, Sam::process($this->html));
    }   
}