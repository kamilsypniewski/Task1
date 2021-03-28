<?php

namespace App\Tests\Service;

use App\Service\ValidationService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValidationServiceTest extends TestCase
{
    protected const PESEL = '94022165719';

    /** @test */
    public function checkFormatOk(): void
    {
        $validationService = new ValidationService();
        self::assertTrue(
            $validationService->checkFormat(self::PESEL),
            "assert checkFormat correct is return false"
        );
    }

    /** @test */
    public function checkFormatOnlyLetters(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkFormat('Aarfgsethde'),
            "assert checkFormat OnlyLetters Incorrect is return true"
        );
    }

    /** @test */
    public function checkFormatCharacters(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkFormat('940d216s71#'),
            "assert checkFormat OnlyLetters Incorrect is return true"
        );
    }

    /** @test */
    public function checkFormatLessNumbers(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkFormat('940221657'),
            "assert checkFormat LessNumbers Incorrect is return true"
        );
    }

    /** @test */
    public function checkFormatMoreNumbers(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkFormat('94022165738557854'),
            "assert checkFormat MoreNumbers Incorrect is return true"
        );
    }

    /** @test */
    public function checkChecksumOk(): void
    {
        $validationService = new ValidationService();
        self::assertTrue(
            $validationService->checkChecksum(self::PESEL),
            "assert value is true or not"
        );
    }

    /** @test */
    public function checkChecksumIncorrect(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkChecksum('94022165739'),
            "assert checkChecksum Incorrect is return true"
        );
    }

    /** @test */
    public function checkDateOk(): void
    {
        $validationService = new ValidationService();
        self::assertTrue(
            $validationService->checkDate(self::PESEL),
            "assert checkDate correct is return false"
        );
    }

    /** @test */
    public function checkDateFutureDate(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkDate('27213184182'),
            "assert checkDate FutureDate Incorrect is return true"
        );
    }

    /** @test */
    public function checkDateMonthMoreDays(): void
    {
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkDate('94022965719'),
            "assert checkDate MonthMoreDays Incorrect is return true"
        );
    }

    /** @test */
    public function checkDateIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $validationService = new ValidationService();
        self::assertFalse(
            $validationService->checkDate('11133965719'),
            "assert checkDate MonthMoreDays Incorrect is return true"
        );
    }


}
