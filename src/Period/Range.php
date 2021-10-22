<?php

/*
 * This file has been added to CalendR, a Fréquence web project.
 *
 * (c) 2012 Ingewikkeld/Stefan Koopmanschap
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CalendR\Period;

/**
 * Represents a Range.
 *
 * @author Stefan Koopmanschap <left@leftontheweb.com>
 */
class Range extends PeriodAbstract
{
    /**
     * @param \DateTimeInterface $begin
     * @param \DateTimeInterface $end
     * @param FactoryInterface   $factory
     */
    public function __construct(\DateTimeInterface $begin, \DateTimeInterface $end, $factory = null)
    {
        $this->factory = $factory;
        $this->begin   = clone $begin;
        $this->end     = clone $end;
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return bool
     */
    public static function isValid(\DateTimeInterface $start)
    {
        return true;
    }

    /**
     * @return Range
     */
    public function getNext()
    {
        $diff = $this->begin->diff($this->end);
        $begin = clone $this->begin;
        $begin->add($diff);
        $end = clone $this->end;
        $end->add($diff);

        return new self($begin, $end, $this->factory);
    }

    /**
     * @return Range
     */
    public function getPrevious()
    {
        $diff = $this->begin->diff($this->end);
        $begin = clone $this->begin;
        $begin->sub($diff);
        $end = clone $this->end;
        $end->sub($diff);

        return new self($begin, $end, $this->factory);
    }

    /**
     * Returns the period as a DatePeriod.
     *
     * @return \DatePeriod
     */
    public function getDatePeriod()
    {
        return new \DatePeriod($this->begin, $this->begin->diff($this->end), $this->end);
    }

    /**
     * Returns a \DateInterval equivalent to the period.
     *
     * @throws Exception\NotImplemented
     */
    public static function getDateInterval()
    {
        throw new Exception\NotImplemented('Range period doesn\'t support getDateInterval().');
    }
}
