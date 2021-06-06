<?php

use Feather\View\Native;
use PHPUnit\Framework\TestCase;

/**
 * Description of NativeTest
 *
 * @author fcarbah
 */
class NativeTest extends TestCase
{

    /** @var \Feather\View\IView * */
    protected static $viewEngine;

    public static function setUpBeforeClass(): void
    {
        $path = dirname(__FILE__, 2) . '/views';
        static::$viewEngine = new Native($path);
    }

    public static function tearDownAfterClass(): void
    {
        static::$viewEngine = null;
    }

    /**
     * @test
     */
    public function willRenderValidPhpView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'index.php';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertTrue(trim($contents) == $data['title']);
    }

    /**
     * @test
     */
    public function willNotRenderNonPhpView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'index.twig';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertFalse(trim($contents) == $data['title']);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function willThrowExceptionForMissingView()
    {
        $this->expectException(\RuntimeException::class);
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'home.php';
        static::$viewEngine->render($file, $data);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function willThrowExceptionForMissingViewData()
    {
        $this->expectException(\RuntimeException::class);
        $data = ['text' => 'Native PHP View Renderer'];
        $file = 'index.php';
        static::$viewEngine->render($file, $data);
    }

}
