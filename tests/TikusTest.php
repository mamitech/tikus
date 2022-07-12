<?php

namespace Tests;

use Tests\TestCase;
use Mamikos\Tikus\Tikus;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Sentry\Laravel\Facade as Sentry;
use Exception;

class TikusTest extends TestCase
{
    public function testReportException()
    {
        $tikus = new Tikus();

        Bugsnag::spy();
        Sentry::spy();

        $tikus->reportException(new Exception());

        Bugsnag::shouldHaveReceived('notifyException')->once();
        Sentry::shouldHaveReceived('captureException')->once();

        $this->assertTrue(true);
    }

    public function testReportExceptionWithMetadata()
    {
        $tikus = new Tikus();

        Bugsnag::spy();
        Sentry::spy();

        $metadata = [ 'data' => 1 ];
        $tikus->reportException(new Exception(), $metadata);

        Bugsnag::shouldHaveReceived('notifyException')->once();

        Sentry::shouldHaveReceived('captureException')->once();
        Sentry::shouldHaveReceived('configureScope')->once();

        $this->assertTrue(true);
    }

    public function testReportExceptionWithEmptyMetadata()
    {
        $tikus = new Tikus();

        Bugsnag::spy();
        Sentry::spy();

        $metadata = [];
        $tikus->reportException(new Exception(), $metadata);

        Bugsnag::shouldHaveReceived('notifyException')->once();

        Sentry::shouldHaveReceived('captureException')->once();
        Sentry::shouldNotHaveReceived('configureScope');

        $this->assertTrue(true);
    }

    public function testReportError()
    {
        $tikus = new Tikus();

        Bugsnag::spy();
        Sentry::spy();

        $tikus->reportError('name', 'message');
        
        Bugsnag::shouldHaveReceived('notifyError')->once();
        Sentry::shouldHaveReceived('captureMessage')->once();

        $this->assertTrue(true);
    }
}