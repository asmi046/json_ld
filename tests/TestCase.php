<?php

namespace Asmi\JsonLd\Tests;

use Asmi\JsonLd\JsonLdServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            JsonLdServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('jsonld.strict', true);
        $app['config']->set('jsonld.pretty_print', false);
        $app['config']->set('jsonld.escape_mode', 'json_encode');
    }
}
