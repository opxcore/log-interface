# Log interface

[![Build Status](https://www.travis-ci.com/opxcore/log-interface.svg?branch=master)](https://www.travis-ci.com/opxcore/log-interface)
[![Coverage Status](https://coveralls.io/repos/github/opxcore/log-interface/badge.svg?branch=master)](https://coveralls.io/github/opxcore/log-interface?branch=master)
[![Latest Stable Version](https://poser.pugx.org/opxcore/log-interface/v/stable)](https://packagist.org/packages/opxcore/log-interface)
[![Total Downloads](https://poser.pugx.org/opxcore/log-interface/downloads)](https://packagist.org/packages/opxcore/log-interface)
[![License](https://poser.pugx.org/opxcore/log-interface/license)](https://packagist.org/packages/opxcore/log-interface)

This is interface for the log used in OpxCore and basics for building `PSR-3` loggers.

# Installing

`composer require opxcore/log-interface`

# Logger basics

## LogException

`OpxCore\Log\Exceptions\LogException::class` is base for any logger exceptions. It
extends `Psr\Log\InvalidArgumentException` for PSR-3 compatibility and should be used as is or as parent for any logger
exceptions.

## AbstractLogger

`OpxCore\Log\AbstractLogger::class` is abstract class implementing
`Psr\Log\LoggerInterface` for PSR-3 compatibility.

AbstractLogger defines several common methods to be used in loggers:

- `formatMessage(string $level, string $message, array $context = []): string`
  returns formatted interpolated message with log level and timestamp.

- `interpolateMessage(string $message, array $context): string`
  interpolates the message with content. See
  [PSR-3-logger-interface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md#12-message)
  . If `'exception'` key presents in context array and has any of `Exception::class` its stacktrace will be included to
  log message.

- `getTimestamp(): string` returns current timestamp in ISO8601 format.