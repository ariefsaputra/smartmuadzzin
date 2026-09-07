<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Filters;
use Config\Security;

final class DeploymentConfigTest extends CIUnitTestCase
{
    public function testTimezoneMatchesTheOperationalLocation(): void
    {
        $this->assertSame('Asia/Jakarta', config(App::class)->appTimezone);
    }

    public function testCsrfAndAdminFilterAreConfigured(): void
    {
        $filters = config(Filters::class);

        $this->assertArrayHasKey('adminauth', $filters->aliases);
        $this->assertArrayHasKey('csrf', $filters->globals['before']);
        $this->assertSame('cookie', config(Security::class)->csrfProtection);
    }
}
