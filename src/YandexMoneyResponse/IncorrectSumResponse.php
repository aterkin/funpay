<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

class IncorrectSumResponse extends Response
{
    public function isSuccessful()
    {
        false;
    }

    public function __toString()
    {
        return "Request failed: `sum` parameter is invalid.";
    }
}
