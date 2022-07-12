<?php

namespace Mamikos\Tikus;

use Throwable;
use Exception;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Sentry\Laravel\Facade as Sentry;

class Tikus
{
    public function reportException(Throwable $throwable, Array $metadata = [])
    {
        try {
            if (empty($metadata) === false)
            {
                Sentry::configureScope(function ($scope) use ($metadata) {
                    try {
                        $scope->setContext('metadata', $metadata);
                    }
                    catch (Exception $e)
                    {
                        $scope->setContext('metadata', [
                            'error in set metadata' => $e->getMessage()
                        ]);
                    }
                });                   
            }

            Sentry::captureException($throwable);
        }
        catch (Exception $e) {}

        try {
            // Bugsnag
            if (empty($metadata) === true)
            {
                Bugsnag::notifyException($throwable);
            }
            else
            {
                Bugsnag::notifyException($throwable, function ($report) use ($metadata) {
                    try {
                        $report->setMetaData($metadata);
                    }
                    catch (Exception $e)
                    {
                        $report->setMetaData([
                            'error in set metadata' => $e->getMessage()
                        ]);
                    }
                });
            }
        }
        catch (Exception $e) {}
    }

    public function reportError($name, $message, Array $metadata = [])
    {
        try {
            // Sentry
            if (empty($metadata) === false)
            {
                Sentry::configureScope(function ($scope) use ($metadata) {
                    try {
                        $scope->setContext('metadata', $metadata);
                    }
                    catch (Exception $e)
                    {
                        $scope->setContext('metadata', [
                            'error in set metadata' => $e->getMessage()
                        ]);
                    }
                });                   
            }
            Sentry::captureMessage("[{$name}] {$message}");
        }
        catch (Exception $e) {}

        try {
            // Bugsnag
            if (empty($metadata) === true)
            {
                Bugsnag::notifyError($name, $message);
            }
            else
            {
                Bugsnag::notifyError($name, $message, function ($report) use ($metadata) {
                    try {
                        $report->setMetaData($metadata);
                    }
                    catch (Exception $e)
                    {
                        $report->setMetaData([
                            'error in set metadata' => $e->getMessage()
                        ]);
                    }
                });
            }
        }
        catch (Exception $e) {}
    }
}