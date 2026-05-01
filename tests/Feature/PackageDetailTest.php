<?php

namespace Tests\Feature;

use Tests\TestCase;

class PackageDetailTest extends TestCase
{
    public function test_package_detail(): void
    {
        $response = $this->get('/packages/umrah-ekonomi-7-hari');
        $status = $response->getStatusCode();
        if ($status !== 200) {
            $log = storage_path('logs/test_debug.log');
            file_put_contents($log, "Status: $status\n" . $response->getContent());
        }
        $this->assertEquals(200, $status, "Package detail page failed");
    }
}
