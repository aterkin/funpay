<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

class SuccessfulResponse extends Response
{
    /** @var int */
    private $code;

    /** @var string */
    private $sum;

    /** @var string */
    private $wallet;

    public function __construct(string $originalText, int $code, string $sum, string $wallet)
    {
        parent::__construct($originalText);

        $this->code   = $code;
        $this->sum    = $sum;
        $this->wallet = $wallet;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    public function getWallet(): string
    {
        return $this->wallet;
    }

    public function isSuccessful()
    {
        return true;
    }

    public function __toString()
    {
        return "Success: code = {$this->code}, sum = {$this->sum}, wallet = {$this->getWallet()}.";
    }
}
