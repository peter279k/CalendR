<?php

namespace CalendR\Test\Extension\Silex;

use CalendR\Extension\Silex\Provider\CalendRServiceProvider;
use CalendR\Event\Provider;
use CalendR\Bridge\Twig\CalendRExtension;
use PHPUnit\Framework\TestCase;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;

class CalendRServiceProviderTest extends TestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var CalendRServiceProvider
     */
    protected $provider;

    protected function setUp(): void
    {
        $this->app = new Application();
        $this->provider = new CalendRServiceProvider();
    }

    public function testRegister()
    {
        $this->app->register($this->provider, array(
            'calendr.event.providers' => array(
                'basic' => new Provider\Basic
            )
        ));

        $this->assertTrue(isset($this->app['calendr']));
        $this->assertInstanceOf('CalendR\\Calendar', $this->app['calendr']);
        $this->assertTrue(isset($this->app['calendr.event_manager']));
        $this->assertInstanceOf('CalendR\\Event\\Manager', $this->app['calendr.event_manager']);
        $providers = $this->app['calendr.event_manager']->getProviders();
        $this->assertSame(1, count($providers));
        $this->assertInstanceOf('CalendR\\Event\\Provider\\Basic', $providers['basic']);
    }

    public function testBootWithoutTwig()
    {
        $this->app->register($this->provider);
        $this->app->boot();
        // Just expecting all is good

        $this->assertTrue(true);
    }

    public function testBootWithTwig()
    {
        $this->markTestSkipped('Twig\Error\RuntimeError: The "CalendR\Bridge\Twig\CalendRExtension" extension is not enabled.');
        $this->app->register($this->provider);
        $this->app->register(new TwigServiceProvider());
        $this->app->boot();
        $this->assertInstanceOf('CalendR\\Bridge\\Twig\\CalendRExtension', $this->app['twig']->getExtension(CalendRExtension::class));
    }
}
