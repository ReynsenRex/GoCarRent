<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Role;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed();
    }

    /** @test */
    public function admin_can_view_bookings_index()
    {
        // Create admin user
        $adminRole = Role::where('name', 'Admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        // Create some test bookings
        $bookings = Booking::factory()->count(3)->create();

        // Act as admin and visit bookings index
        $response = $this->actingAs($admin)->get(route('admin.bookings.index'));

        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.index');
        $response->assertViewHas('bookings');
    }

    /** @test */
    public function admin_can_view_specific_booking_details()
    {
        // Create admin user
        $adminRole = Role::where('name', 'Admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        // Create a test booking
        $booking = Booking::factory()->create();

        // Act as admin and visit booking details
        $response = $this->actingAs($admin)->get(route('admin.bookings.show', $booking));

        // Assert successful response
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.show');
        $response->assertViewHas('booking');
        $response->assertSee($booking->user->name);
        $response->assertSee($booking->car->brand);
    }

    /** @test */
    public function non_admin_cannot_access_booking_management()
    {
        // Create customer user
        $customerRole = Role::where('name', 'Customer')->first();
        $customer = User::factory()->create(['role_id' => $customerRole->id]);

        // Try to access admin bookings
        $response = $this->actingAs($customer)->get(route('admin.bookings.index'));

        // Should be denied access
        $response->assertStatus(403);
    }

    /** @test */
    public function booking_show_page_displays_all_required_information()
    {
        // Create admin user
        $adminRole = Role::where('name', 'Admin')->first();
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        // Create a test booking
        $booking = Booking::factory()->create([
            'notes' => 'Test booking notes'
        ]);

        // Act as admin and visit booking details
        $response = $this->actingAs($admin)->get(route('admin.bookings.show', $booking));

        // Assert all key information is displayed
        $response->assertSee('Booking Details');
        $response->assertSee('Customer Information');
        $response->assertSee('Car Information');
        $response->assertSee('Pricing Information');
        $response->assertSee('Booking Timeline');
        $response->assertSee($booking->notes);
    }
}
