<?php
/*
 * This file is part of the OpxCore.
 *
 * Copyright (c) Lozovoy Vyacheslav <opxcore@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpxCore\Tests\Log;

class AbstractLogger extends \OpxCore\Log\AbstractLogger
{
    public string $log;

    public function log($level, $message, array $context = array()): void
    {
        $this->log = $this->formatMessage($level, $message, $context);
    }

    public function formatMessage(string $level, string $message, array $context = []): string
    {
        return parent::formatMessage($level, $message, $context);
    }

    public function interpolateMessage(string $message, array $context): string
    {
        return parent::interpolateMessage($message, $context);
    }

    public function getTimestamp(): string
    {
        return parent::getTimestamp();
    }
}