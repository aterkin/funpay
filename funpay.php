<?php declare(strict_types=1);

use Funpay\YandexMoneyResponse\BalanceNotEnoughResponse;
use Funpay\YandexMoneyResponse\IncorrectSumResponse;
use Funpay\YandexMoneyResponse\IncorrectWalletResponse;
use Funpay\YandexMoneyResponse\ParsingFailedResponse;
use Funpay\YandexMoneyResponse\Response;
use Funpay\YandexMoneyResponse\SuccessfulResponse;
use Spatie\Regex\Regex;

require_once "vendor/autoload.php";

/*
 * "Напишите на PHP функцию, которая принимает строку (текст сообщения) и возвращает извлеченные из неё код подтверждения, сумму и кошелек."
 */
function parseYandexMoneyResponse(string $originalText): Response
{
    /*
     * По условию задачи порядок полей, текст и пунктуация могут меняться, и при этом функция должна продолжать работать.
     * Поэтому я решил зацепиться за факты, которые не относятся к тексту, порядку полей и пунктуации:
     * - кошелёк это всегда длинное число специального формата (41001...), встречается строго один раз
     * - сумма и пароль это числа, но сумма сопровождается символом валюты
     */

    $incorrectWallet = Regex::match('/Кошелек Яндекс.Денег указан неверно./u', $originalText);
    if ($incorrectWallet->hasMatch())
    {
        return new IncorrectWalletResponse($originalText);
    }

    $incorrectSum = Regex::match('/Сумма указана неверно./u', $originalText);
    if ($incorrectSum->hasMatch())
    {
        return new IncorrectSumResponse($originalText);
    }

    $balanceNotEnough = Regex::match('/Недостаточно средств./u', $originalText);
    if ($balanceNotEnough->hasMatch())
    {
        return new BalanceNotEnoughResponse($originalText);
    }

    // ограничения от 7 до 10 цифр получено путём исследования эмулятора
    $walletMatches = Regex::matchAll('/(41001\d{7,10})/', $originalText)->results();
    if (count($walletMatches) !== 1)
    {
        return new ParsingFailedResponse($originalText, "Wallet matcher can not be matched.");
    }
    $wallet = $walletMatches[0]->result();

    $sumMatches = Regex::matchAll('/\d+((\.|,)\d{1,2})?р\./u', $originalText)->results();
    if (count($sumMatches) !== 1)
    {
        return new ParsingFailedResponse($originalText, "Sum matcher can not be matched.");
    }

    $sum = $sumMatches[0]->result();

    $codeMatches = Regex::matchAll('/(^|[^\d])(\d{4,10})([^р\d]|$)/u', $originalText)->results();
    if (count($codeMatches) !== 1)
    {
        return new ParsingFailedResponse($originalText, "Code matcher can not be matched.");
    }
    $code = (int) $codeMatches[0]->group(2);

    return new SuccessfulResponse($originalText, $code, $sum, $wallet);
}

$cases = [
    'Пароль: 1207<br />
Спишется 1,01р.<br />
Перевод на счет 410012762728229',
    'Никому не говорите пароль! Его спрашивают только мошенники.<br />
Пароль: 91112<br />
Перевод на счет 410012762728229<br />
Вы потратите 10000р.',
    'Пароль: 7952<br />
Спишется 19,1р.<br />
Перевод на счет 410012762728229',
    'Кошелек Яндекс.Денег указан неверно.',
    'Сумма указана неверно.',
    'Недостаточно средств.',
];

foreach ($cases as $case)
{
    echo parseYandexMoneyResponse($case);
    echo "\n-----------------------\n\n";
}

