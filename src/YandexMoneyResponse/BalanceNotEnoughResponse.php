<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

class BalanceNotEnoughResponse extends Response
{
    public function isSuccessful()
    {
        return false;
    }

    public function __toString()
    {
        return "Request failed: balance is not enough.";
    }
}
