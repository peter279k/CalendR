<?php

namespace CalendR\Period;

/**
 * Represents a Month.
 *
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class Month extends PeriodAbstract implements \Iterator
{
    /**
     * @var PeriodInterface
     */
    private $current;

    /**
     * Returns the period as a DatePeriod.
     *
     * @return \DatePeriod
     */
    public function getDatePeriod()
    {
        return new \DatePeriod($this->begin, new \DateInterval('P1D'), $this->end);
    }

    /**
     * Returns a Day array.
     *
     * @return array<Day>
     */
    public function getDays()
    {
        $days = array();
        foreach ($this->getDatePeriod() as $date) {
            $days[] = $this->getFactory()->createDay($date);
        }

        return $days;
    }

    /**
     * Returns the first day of the first week of month.
     * First day of week is configurable via {@link Factory:setOption()}.
     *
     * @return \DateTimeInterface
     */
    public function getFirstDayOfFirstWeek()
    {
        return $this->getFactory()->findFirstDayOfWeek($this->begin);
    }

    /**
     * Returns a Range period beginning at the first day of first week of this month,
     * and ending at the last day of the last week of this month.
     *
     * @return Range
     */
    public function getExtendedMonth()
    {
        return $this->getFactory()->createRange($this->getFirstDayOfFirstWeek(), $this->getLastDayOfLastWeek());
    }

    /**
     * Returns the last day of last week of month
     * First day of week is configurable via {@link Factory::setOption()}.
     *
     * @return \DateTimeInterface
     */
    public function getLastDayOfLastWeek()
    {
        $lastDay = clone $this->end;
        $lastDay->sub(new \DateInterval('P1D'));

        return $this->getFactory()->findFirstDayOfWeek($lastDay)->add(new \DateInterval('P6D'));
    }

    /*
    * Iterator implementation
    */

    /**
     * @return Week
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        if (!$this->valid()) {
            $this->current = $this->getFactory()->createWeek($this->getFirstDayOfFirstWeek());
        } else {
            $this->current = $this->current->getNext();

            if ($this->current->getBegin()->format('m') != $this->begin->format('m')) {
                $this->current = null;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->current->getBegin()->format('W');
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return null !== $this->current();
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->current = null;
        $this->next();
    }

    /**
     * Returns the month name (probably in english).
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('F');
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return bool
     */
    public static function isValid(\DateTimeInterface $start)
    {
        return $start->format('d H:i:s') === '01 00:00:00';
    }

    /**
     * Returns a \DateInterval equivalent to the period.
     *
     * @return \DateInterval
     */
    public static function getDateInterval()
    {
        return new \DateInterval('P1M');
    }
}
