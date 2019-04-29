<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

class IncorrectWalletResponse extends Response
{
    public function isSuccessful()
    {
        false;
    }

    public function __toString()
    {
        return "Request failed: `receiver` parameter is invalid.";
    }
}
