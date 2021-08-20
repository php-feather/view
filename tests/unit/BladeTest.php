<?php

use PHPUnit\Framework\TestCase;
use Feather\View\Blade;

/**
 * Description of BladeTest
 *
 * @author fcarbah
 */
class BladeTest extends TestCase
{

    protected static $viewEngine;

    public static function setUpBeforeClass(): void
    {
        $path = dirname(__FILE__, 2) . '/views';

        static::$viewEngine = new Blade($path, $path);
    }

    public static function tearDownAfterClass(): void
    {
        static::$viewEngine = null;
    }

    /**
     * @test
     */
    public function willRenderValidBladeView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'home';
        $contents = static::$viewEngine->render($file, $data);
        $expectedText = '<h3>Title: ' . $data['title'] . '</h3>';
        $this->assertTrue(trim($contents) == $expectedText);
    }

    /**
     * @test
     */
    public function willRenderValidPhpView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'index';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertTrue(trim($contents) == $data['title']);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function willNotRenderNonPhpView()
    {
        $this->expectException(\InvalidArgumentException::class);
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'admin';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertFalse(trim($contents) == $data['title']);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function willThrowExceptionForMissingView()
    {
        $this->expectException(\InvalidArgumentException::class);
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'test';
        static::$viewEngine->render($file, $data);
    }

    /**
     * @test
     */
    public function willThrowExceptionForMissingViewData()
    {
        $this->expectNotice();
        $data = ['text' => 'Native PHP View Renderer'];
        $file = 'index';
        static::$viewEngine->render($file, $data);
    }

}
