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

use Exception;
use PHPUnit\Framework\TestCase;

class AbstractLoggerTest extends TestCase
{
    protected string $iso8601pattern = '\d\d\d\d-\d\d-\d\dT\d\d:\d\d:\d\d\+\d\d:\d\d';

    public function testTimeStamp(): void
    {
        $logger = new AbstractLogger();
        $ts = $logger->getTimestamp();
        self::assertMatchesRegularExpression("/{$this->iso8601pattern}/", $ts);
    }

    public function testInterpolationSimple(): void
    {
        $logger = new AbstractLogger();
        $interpolated = $logger->interpolateMessage('hello {context}', ['context' => 'world']);
        self::assertEquals('hello world', $interpolated);
    }

    public function testInterpolationWithStacktrace(): void
    {
        $logger = new AbstractLogger();
        $exception = new Exception('Test exception');

        $interpolated = $logger->interpolateMessage('hello {context}', [
            'context' => 'world',
            'exception' => $exception,
        ]);

        $interpolated = explode("\n", $interpolated);

        self::assertEquals('hello world', $interpolated[0]);
        self::assertGreaterThan(1, count($interpolated));
    }

    public function testFormatMessage(): void
    {
        $logger = new AbstractLogger();
        $logger->log('info', 'hello {context}', ['context' => 'world']);

        self::assertMatchesRegularExpression("/\[{$this->iso8601pattern}\]\sinfo\s\>\shello\sworld/", $logger->log);
    }
}
