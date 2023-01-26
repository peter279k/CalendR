<?php

namespace CalendR\Period;

/**
 * Represents a minute.
 *
 * @author Zander Baldwin <mynameis@zande.rs>
 */
class Minute extends PeriodAbstract implements \Iterator
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
        return new \DatePeriod($this->begin, new \DateInterval('PT1S'), $this->end);
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return bool
     */
    public static function isValid(\DateTimeInterface $start)
    {
        return $start->format('s') == '00';
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
            $this->current = $this->getFactory()->createSecond($this->begin);
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
        return (int) $this->current->getBegin()->format('i');
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
     * Returns the minute.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('i');
    }

    /**
     * Returns a \DateInterval equivalent to the period.
     *
     * @return \DateInterval
     */
    public static function getDateInterval()
    {
        return new \DateInterval('PT1M');
    }
}
