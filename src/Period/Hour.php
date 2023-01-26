<?php

namespace CalendR\Period;
use CalendR\Period\Exception\NotAnHour;

/**
 * Represents an hour.
 *
 * @author Zander Baldwin <mynameis@zande.rs>
 */
class Hour extends PeriodAbstract implements \Iterator
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
        return new \DatePeriod($this->begin, new \DateInterval('PT1M'), $this->end);
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return bool
     */
    public static function isValid(\DateTimeInterface $start)
    {
        return $start->format('i:s') == '00:00';
    }

    /**
     * {@inheritdoc}
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
        if (null === $this->current) {
            $this->current = $this->getFactory()->createMinute($this->begin);
        } else {
            $this->current = $this->current->getNext();
            if (!$this->contains($this->current->getBegin())) {
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
        return (int) $this->current->getBegin()->format('G');
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return null !== $this->current;
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
     * Returns the hour.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('G');
    }

    /**
     * Returns a \DateInterval equivalent to the period.
     *
     * @return \DateInterval
     */
    public static function getDateInterval()
    {
        return new \DateInterval('PT1H');
    }

    /**
     * @return NotAnHour
     */
    protected function createInvalidException()
    {
        return new NotAnHour;
    }
}
