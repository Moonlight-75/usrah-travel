<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class FullRouteTest extends TestCase
{
    public function test_public_routes(): void
    {
        $routes = [
            ['GET', '/', 200],
            ['GET', '/packages', 200],
            ['GET', '/about', 200],
            ['GET', '/gallery', 200],
            ['GET', '/contact', 200],
            ['GET', '/packages/umrah-ekonomi-7-hari', 200],
            ['GET', '/login', 200],
            ['GET', '/register', 200],
            ['GET', '/forgot-password', 200],
            ['GET', '/dashboard', 302],
            ['GET', '/admin', 302],
            ['GET', '/portal', 302],
        ];

        foreach ($routes as [$method, $uri, $expected]) {
            $response = $this->$method($uri);
            $this->assertEquals($expected, $response->getStatusCode(), "$method $uri");
        }
    }

    public function test_nonexistent_package_returns_404(): void
    {
        $response = $this->get('/packages/nonexistent-package-slug');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_contact_form(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test', 'email' => 'test@test.com', 'phone' => '0123456789',
            'subject' => 'general', 'message' => 'Test message',
        ]);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_admin_routes(): void
    {
        $admin = User::where('email', 'admin@usrahtravel.com')->first();
        $this->actingAs($admin);

        $routes = [
            'admin', 'admin/bookings', 'admin/customers', 'admin/packages',
            'admin/payments', 'admin/invoices', 'admin/vendors', 'admin/tours',
            'admin/documents', 'admin/contacts', 'admin/reports', 'admin/users',
            'admin/bookings/create', 'admin/packages/create', 'admin/payments/create',
            'admin/vendors/create',
        ];

        foreach ($routes as $uri) {
            $response = $this->get("/$uri");
            $this->assertEquals(200, $response->getStatusCode(), "GET /$uri");
        }
    }

    public function test_admin_detail_routes(): void
    {
        $admin = User::where('email', 'admin@usrahtravel.com')->first();
        $this->actingAs($admin);

        $routes = [
            '/admin/bookings/1', '/admin/bookings/1/edit',
            '/admin/customers/1', '/admin/customers/1/edit',
            '/admin/packages/1', '/admin/packages/1/edit',
            '/admin/payments/1', '/admin/invoices/1',
            '/admin/vendors/1', '/admin/vendors/1/edit',
            '/admin/contacts/1', '/admin/users/1/edit',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $status = $response->getStatusCode();
            $this->assertTrue(
                in_array($status, [200, 404]),
                "GET $uri returned $status"
            );
        }
    }

    public function test_portal_routes(): void
    {
        $customer = User::where('email', 'haziq@gmail.com')->first();
        $this->actingAs($customer);

        $routes = ['portal', 'portal/bookings', 'portal/documents', 'portal/payments', 'portal/profile'];

        foreach ($routes as $uri) {
            $response = $this->get("/$uri");
            $this->assertEquals(200, $response->getStatusCode(), "GET /$uri");
        }
    }

    public function test_portal_booking_detail(): void
    {
        $customer = User::where('email', 'haziq@gmail.com')->first();
        $this->actingAs($customer);

        $response = $this->get('/portal/bookings/1');
        $status = $response->getStatusCode();
        $this->assertTrue(in_array($status, [200, 404]), "Booking detail returned $status");
    }

    public function test_customer_cannot_access_admin(): void
    {
        $customer = User::where('email', 'haziq@gmail.com')->first();
        $this->actingAs($customer);

        $response = $this->get('/admin');
        $this->assertEquals(403, $response->getStatusCode(), 'Customer should not access admin');
    }

    public function test_unauthenticated_redirects(): void
    {
        $response = $this->get('/portal');
        $this->assertEquals(302, $response->getStatusCode());

        $response = $this->get('/admin');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
