<?php

use Feather\View\Twig;
use PHPUnit\Framework\TestCase;

/**
 * Description of TwigTest
 *
 * @author fcarbah
 */
class TwigTest extends TestCase
{

    /** @var \Feather\View\IView * */
    protected static $viewEngine;

    public static function setUpBeforeClass(): void
    {
        $path = dirname(__FILE__, 2) . '/views';
        static::$viewEngine = new Twig($path);
    }

    public static function tearDownAfterClass(): void
    {
        static::$viewEngine = null;
    }

    /**
     * @test
     */
    public function willRenderTwigView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'admin.twig';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertTrue(trim($contents) == $data['title']);
    }

    /**
     * @test
     */
    public function willNotRenderStrictPhpView()
    {
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'index.php';
        $contents = static::$viewEngine->render($file, $data);
        $this->assertTrue(trim($contents) != $data['title']);
    }

    /**
     * @test
     * @expectedException \Twig\Error\LoaderError
     */
    public function willThrowExceptionForMissingView()
    {
        $this->expectException(\Twig\Error\LoaderError::class);
        $data = ['title' => 'Native PHP View Renderer'];
        $file = 'home.twig';
        static::$viewEngine->render($file, $data);
    }

}
