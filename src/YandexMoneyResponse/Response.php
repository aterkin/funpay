<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

abstract class Response
{
    /** @var string */
    protected $originalText;

    public function __construct(string $originalText)
    {
        $this->originalText = $originalText;
    }

    abstract public function isSuccessful();

    abstract public function __toString();

}
