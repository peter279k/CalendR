<?php

/*
 * This file is part of CalendR, a Fréquence web project.
 *
 * (c) 2012 Fréquence web
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CalendR\Period;

use CalendR\Event\EventInterface;

/**
 * An abstract class that represent a date period and provide some base helpers.
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
abstract class PeriodAbstract implements PeriodInterface
{
    /**
     * @var \DateTimeInterface
     */
    protected $begin;

    /**
     * @var \DateTimeInterface
     */
    protected $end;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @param \DateTimeInterface $begin
     * @param FactoryInterface   $factory
     *
     * @throws \CalendR\Exception
     */
    public function __construct(\DateTimeInterface $begin, FactoryInterface $factory)
    {
        $this->factory = $factory;
        if (!static::isValid($begin)) {
            throw $this->createInvalidException();
        }

        $this->begin = clone $begin;
        $this->end   = clone $begin;
        $this->end->add($this->getDateInterval());
    }

    /**
     * Checks if the given period is contained in the current period.
     *
     * @param \DateTimeInterface $date
     *
     * @return bool true if the period contains this date
     */
    public function contains(\DateTimeInterface $date)
    {
        return $this->begin <= $date && $date < $this->end;
    }

    /**
     * Checks if a period is equals to an other.
     *
     * @param PeriodInterface $period
     *
     * @return bool
     */
    public function equals(PeriodInterface $period)
    {
        return
            $period instanceof static &&
            $this->begin->format('Y-m-d-H-i-s') === $period->getBegin()->format('Y-m-d-H-i-s')
        ;
    }

    /**
     * Returns true if the period include the other period
     * given as argument.
     *
     * @param PeriodInterface $period
     * @param bool            $strict
     *
     * @return bool
     */
    public function includes(PeriodInterface $period, $strict = true)
    {
        if (true === $strict) {
            return $this->getBegin() <= $period->getBegin() && $this->getEnd() >= $period->getEnd();
        }

        return
            $this->includes($period, true) ||
            $period->includes($this, true) ||
            $this->contains($period->getBegin()) ||
            $this->contains($period->getEnd())
        ;
    }

    /**
     * Returns if $event is during this period.
     * Non strict. Must return true if :
     *  * Event is during period
     *  * Period is during event
     *  * Event begin is during Period
     *  * Event end is during Period.
     *
     * @param EventInterface $event
     *
     * @return bool
     */
    public function containsEvent(EventInterface $event)
    {
        return
            $event->containsPeriod($this) ||
            $event->isDuring($this) ||
            $this->contains($event->getBegin()) ||
            ($event->getEnd() && $this->contains($event->getEnd())  && $event->getEnd()->format('c') !== $this->begin->format('c'))
        ;
    }

    /**
     * Format the period to a string.
     *
     * @param string $format
     *
     * @return string
     */
    public function format($format)
    {
        return $this->begin->format($format);
    }

    /**
     * Returns if the current period is the current one.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->contains(new \DateTime());
    }

    /**
     * Gets the next period of the same type.
     *
     * @return PeriodInterface
     */
    public function getNext()
    {
        return new static($this->end, $this->factory);
    }

    /**
     * Gets the previous period of the same type.
     *
     * @return PeriodInterface
     */
    public function getPrevious()
    {
        $start = clone $this->begin;
        $start->sub(static::getDateInterval());

        return new static($start, $this->factory);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getBegin()
    {
        return clone $this->begin;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return clone $this->end;
    }

    /**
     * @return FactoryInterface
     */
    public function getFactory()
    {
        if (null === $this->factory) {
            $this->factory = new Factory();
        }

        return $this->factory;
    }

    /**
     * @return \CalendR\Exception
     */
    protected function createInvalidException()
    {
        $class = 'CalendR\Period\Exception\NotA' . (new \ReflectionClass($this))->getShortName();

        return new $class;
    }
}
