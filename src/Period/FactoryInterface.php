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

/**
 * Class FactoryInterface.
 */
interface FactoryInterface
{
    /**
     * Create and return a Second.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createSecond(\DateTimeInterface $begin);

    /**
     * Create and return a Minute.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createMinute(\DateTimeInterface $begin);

    /**
     * Create and return an Hour.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createHour(\DateTimeInterface $begin);

    /**
     * Create and return a Day.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createDay(\DateTimeInterface $begin);

    /**
     * Create and return a Week.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createWeek(\DateTimeInterface $begin);

    /**
     * Create and return a Month.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createMonth(\DateTimeInterface $begin);

    /**
     * Create and return a Year.
     *
     * @param \DateTimeInterface $begin
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createYear(\DateTimeInterface $begin);

    /**
     * Create and return a Range.
     *
     * @param \DateTimeInterface $begin
     * @param \DateTimeInterface $end
     *
     * @return \CalendR\Period\PeriodInterface
     */
    public function createRange(\DateTimeInterface $begin, \DateTimeInterface $end);

    /**
     * @param int $firstWeekday
     *
     * @return FactoryInterface
     */
    public function setFirstWeekday($firstWeekday);

    /**
     * @return int
     */
    public function getFirstWeekday();

    /**
     * Find the first day of the given week.
     *
     * @param \DateTimeInterface $dateTime
     *
     * @return \DateTimeInterface
     */
    public function findFirstDayOfWeek($dateTime);
}
