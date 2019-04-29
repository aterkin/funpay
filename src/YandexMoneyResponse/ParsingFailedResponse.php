<?php declare(strict_types=1);

namespace Funpay\YandexMoneyResponse;

class ParsingFailedResponse extends Response
{
    private $message;

    public function __construct(string $originalText, string $message)
    {
        parent::__construct($originalText);
        $this->message = $message;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function __toString()
    {
        return "Parsing failed: {$this->message} \nsend message to dev team's Slack.\nOriginal text:\n{$this->originalText}";
    }
}
