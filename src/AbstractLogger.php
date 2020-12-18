<?php
/*
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Log;

use DateTime;
use Exception;

abstract class AbstractLogger extends \Psr\Log\AbstractLogger
{

    /**
     * Format and interpolate message.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     *
     * @return  string
     */
    protected function formatMessage(string $level, string $message, array $context = []): string
    {
        $logMessage = $this->interpolateMessage($message, $context);
        $timestamp = $this->getTimestamp();

        return "[{$timestamp}] {$level} > " . $logMessage;
    }

    /**
     * Format message with context and exception stacktrace.
     *
     * @param string $message
     * @param array $context
     *
     * @return  string
     *
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#12-message
     */
    protected function interpolateMessage(string $message, array $context): string
    {
        // First replace {placeholders} in message with $context['placeholders']

        // build a replacement array with braces around the context keys
        $replace = [];

        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (is_string($val) || method_exists($val, '__toString')) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        $processed = strtr($message, $replace);

        /** @var Exception $exception */
        $exception = $context['exception'] ?? null;

        if ($exception instanceof Exception) {
            $stackTrace = $exception->getTraceAsString();
            $processed .= "\n{$stackTrace}";
        }

        return $processed;
    }

    /**
     * Get datetime in ISO8601 format.
     *
     * @return  string
     */
    protected function getTimestamp(): string
    {
        return date(DateTime::ATOM);
    }
}