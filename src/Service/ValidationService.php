<?php

namespace App\Service;

use DateTime;

class ValidationService
{
    public function handle(string $pesel): void
    {
        if (false === $this->checkFormat($pesel)) {
            throw new \InvalidArgumentException('wrong length');
        }

        if (false === $this->checkChecksum($pesel)) {
            throw new \InvalidArgumentException('invalid checksum');
        }

        if (false === $this->checkDate($pesel)) {
            throw new \InvalidArgumentException('invalid date');
        }
    }

    /**
     * @param string $pesel
     * @return bool
     */
    public function checkChecksum(string $pesel): bool
    {
        $sum = 0;
        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1];

        foreach (str_split($pesel) as $position => $digit) {
            $sum += $digit * $weights[$position];
        }

        return (int)substr($sum % 10, -1, 1) === 0;
    }

    /**
     * @param string $pesel
     * @return bool
     */
    public function checkFormat(string $pesel): bool
    {
        return (bool)preg_match('/^[0-9]{11}$/', $pesel);
    }

    /**
     * @param string $pesel
     * @return bool
     * @throws \Exception
     */
    public function checkDate(string $pesel): bool
    {
        $date = $this->getBirthDate($pesel);
        $dateBirth = DateTime::createFromFormat('Y-m-d', $date['year'] . '-' . $date['month'] . '-' . $date['day']);

        if (!$dateBirth) {
            return false;
        }

        $dateNow = new DateTime(date('Y-m-d'));
        if ($dateBirth > $dateNow) {
            return false;
        }

        try {
            $maxDays = cal_days_in_month(CAL_GREGORIAN, $date['month'], $date['year']);
        } catch (\Exception $exception) {
            throw new \InvalidArgumentException($exception->getMessage());
        }

        if ($maxDays < $date['day']) {
            return false;
        }

        return true;
    }

    /**
     * @param string $pesel
     * @return array
     */
    protected function getBirthDate(string $pesel): array
    {
        $year = substr($pesel, 0, 2);
        $month = substr($pesel, 2, 2);
        $day = substr($pesel, 4, 2);

        $century = $pesel[2];
        $century += 2;
        $century %= 10;
        $century = round($century / 2, 0, PHP_ROUND_HALF_DOWN);
        $century += 18;

        $year = $century . $year;

        $month = str_pad($month % 20, 2, '0', STR_PAD_LEFT);

        return [
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ];
    }

}