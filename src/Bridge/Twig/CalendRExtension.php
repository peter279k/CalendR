<?php

namespace CalendR\Bridge\Twig;

use CalendR\Calendar;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Extension for using periods and events from Twig
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class CalendRExtension extends AbstractExtension
{
    /**
     * @var Calendar
     */
    protected $factory;

    /**
     * @param Calendar $factory
     */
    public function __construct(Calendar $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return array<\Twig\TwigFunction>
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('calendr_year', [$this, 'getYear']),
            new TwigFunction('calendr_month', [$this, 'getMonth']),
            new TwigFunction('calendr_week', [$this, 'getWeek']),
            new TwigFunction('calendr_day', [$this, 'getDay']),
            new TwigFunction('calendr_events', [$this, 'getEvents']),
        ];
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return call_user_func_array([$this->factory, 'getYear'], func_get_args());
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return call_user_func_array([$this->factory, 'getMonth'], func_get_args());
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return call_user_func_array([$this->factory, 'getWeek'], func_get_args());
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return call_user_func_array([$this->factory, 'getDay'], func_get_args());
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return call_user_func_array([$this->factory, 'getEvents'], func_get_args());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::class;
    }
}
