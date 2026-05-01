<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Vendor;
use App\Models\TourGroup;
use App\Models\Document;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() > 0) {
            return;
        }

        $this->createUsers();
        $this->createPackages();
        $this->createVendors();
        $this->createBookings();
        $this->createContacts();
    }

    private function createUsers(): void
    {
        User::create([
            'name' => 'Admin Usrah',
            'email' => 'admin@usrahtravel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '+60 3-8000 8000',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff Ahmad',
            'email' => 'ahmad@usrahtravel.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
            'phone' => '+60 19-123 4567',
            'email_verified_at' => now(),
        ]);

        $customers = [
            ['name' => 'Muhammad Haziq', 'email' => 'haziq@gmail.com', 'phone' => '+60 17-888 9999'],
            ['name' => 'Nurul Aisyah', 'email' => 'aisyah@gmail.com', 'phone' => '+60 13-222 3333'],
            ['name' => 'Ahmad Farhan', 'email' => 'farhan@gmail.com', 'phone' => '+60 11-444 5555'],
            ['name' => 'Siti Khadijah', 'email' => 'khadijah@gmail.com', 'phone' => '+60 12-666 7777'],
            ['name' => 'Ismail bin Ibrahim', 'email' => 'ismail@gmail.com', 'phone' => '+60 19-888 1111'],
        ];

        foreach ($customers as $c) {
            $user = User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'password' => Hash::make('password'),
                'role' => 'customer',
                'is_active' => true,
                'phone' => $c['phone'],
                'email_verified_at' => now(),
            ]);

            Customer::create([
                'user_id' => $user->id,
                'ic_passport_no' => 'A' . rand(1000000, 9999999),
                'ic_passport_expiry' => now()->addYears(3),
                'address' => 'No. ' . rand(1, 200) . ', Jalan ' . Str::random(8),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'postcode' => fake()->postcode(),
                'country' => 'Malaysia',
                'emergency_name' => fake()->name(),
                'emergency_phone' => '+60 ' . rand(10, 19) . '-' . rand(100, 999) . ' ' . rand(1000, 9999),
                'emergency_relation' => 'Spouse',
            ]);
        }
    }

    private function createPackages(): void
    {
        $packages = [
            [
                'name' => 'Umrah Ekonomi 7 Hari',
                'slug' => 'umrah-ekonomi-7-hari',
                'category' => 'umrah',
                'description' => 'Pakej Umrah ekonomi selama 7 hari dengan penginapan berhampiran Masjidil Haram. Sesuai untuk jemaah yang mahu melaksanakan Umrah dengan bajet yang berpatutan.',
                'duration_days' => 7,
                'duration_nights' => 6,
                'price' => 6950.00,
                'max_pax' => 50,
                'is_featured' => true,
                'includes' => json_encode(['Tiket penerbangan', 'Hotel 3 bintang', 'Muthawwif', 'Transportasi', 'Visa Umrah', 'Insurran perjalanan']),
                'excludes' => json_encode(['Belanja peribadi', 'Telekung & Ihram', 'Tambang Lapangan Terbang']),
            ],
            [
                'name' => 'Umrah Premium 10 Hari',
                'slug' => 'umrah-premium-10-hari',
                'category' => 'umrah',
                'description' => 'Pakej Umrah premium selama 10 hari dengan penginapan hotel berbintang 5 yang berhadapan dengan Masjidil Haram dan Masjid Nabawi. Pengalaman Umrah yang mewah dan selesa.',
                'duration_days' => 10,
                'duration_nights' => 9,
                'price' => 12500.00,
                'discount_price' => 11500.00,
                'max_pax' => 30,
                'is_featured' => true,
                'includes' => json_encode(['Tiket penerbangan business class', 'Hotel 5 bintang', 'Muthawwif VIP', 'Transportasi VIP', 'Visa Umrah', 'Insurran perjalanan', 'Makan 3 kali sehari']),
                'excludes' => json_encode(['Belanja peribadi', 'Telekung & Ihram']),
            ],
            [
                'name' => 'Umrah Keluarga 14 Hari',
                'slug' => 'umrah-keluarga-14-hari',
                'category' => 'umrah',
                'description' => 'Pakej Umrah yang sesuai untuk keluarga dengan perancangan perjalanan yang selesa dan fleksibel. Kunjungi tempat-tempat bersejarah di Makkah dan Madinah.',
                'duration_days' => 14,
                'duration_nights' => 13,
                'price' => 15500.00,
                'max_pax' => 40,
                'is_featured' => true,
                'includes' => json_encode(['Tiket penerbangan', 'Hotel 4 bintang', 'Muthawwif', 'Transportasi', 'Visa Umrah', 'Insurran perjalanan', 'Makan sarapan', 'Ziarah tempat bersejarah']),
                'excludes' => json_encode(['Belanja peribadi', 'Telekung & Ihram', 'Tambang Lapangan Terbang']),
            ],
            [
                'name' => 'Umrah Ramadhan 12 Hari',
                'slug' => 'umrah-ramadhan-12-hari',
                'category' => 'umrah',
                'description' => 'Pakej Umrah istimewa pada bulan Ramadhan. Laksanakan Umrah dan tarawih di Masjidil Haram untuk mendapatkan ganjaran yang berlipat ganda.',
                'duration_days' => 12,
                'duration_nights' => 11,
                'price' => 18900.00,
                'discount_price' => 17500.00,
                'max_pax' => 45,
                'is_featured' => true,
                'includes' => json_encode(['Tiket penerbangan', 'Hotel 4 bintang', 'Muthawwif', 'Transportasi', 'Visa Umrah', 'Insurran perjalanan', 'Makan iftar & sahur']),
                'excludes' => json_encode(['Belanja peribadi', 'Telekung & Ihram']),
            ],
            [
                'name' => 'Tur Halal Turki 9 Hari',
                'slug' => 'tur-halal-turki-9-hari',
                'category' => 'halal_tour',
                'description' => 'Terokai keindahan Turki dengan pakej tur halal. Lawati Istanbul, Cappadocia, Pamukkale dan banyak lagi dengan makanan halal sepenuhnya.',
                'duration_days' => 9,
                'duration_nights' => 8,
                'price' => 5500.00,
                'max_pax' => 40,
                'is_featured' => false,
                'includes' => json_encode(['Tiket penerbangan', 'Hotel 4 bintang', 'Pemandu pelancong', 'Transportasi', 'Sarapan & makan malam', 'Tiket tarikan pelancong']),
                'excludes' => json_encode(['Belanja peribadi', 'Tambang Lapangan Terbang']),
            ],
            [
                'name' => 'Tur Halal Jordan 7 Hari',
                'slug' => 'tur-halal-jordan-7-hari',
                'category' => 'halal_tour',
                'description' => 'Lawati Laut Mati, Petra, dan Amman dalam pakej tur halal Jordan. Pengalaman perjalanan yang memenuhi keperluan Muslim.',
                'duration_days' => 7,
                'duration_nights' => 6,
                'price' => 4800.00,
                'max_pax' => 35,
                'is_featured' => false,
                'includes' => json_encode(['Tiket penerbangan', 'Hotel 3 bintang', 'Pemandu pelancong', 'Transportasi', 'Sarapan & makan malam']),
                'excludes' => json_encode(['Belanja peribadi', 'Tambang Lapangan Terbang']),
            ],
            [
                'name' => 'Corporate Travel - Jeddah',
                'slug' => 'corporate-travel-jeddah',
                'category' => 'corporate',
                'description' => 'Pakej perjalanan korporat ke Jeddah untuk urusan perniagaan. Termasuk penginapan, transportasi, dan sokongan logistik.',
                'duration_days' => 5,
                'duration_nights' => 4,
                'price' => 8500.00,
                'max_pax' => 20,
                'is_featured' => false,
                'includes' => json_encode(['Tiket penerbangan business class', 'Hotel 4 bintang', 'Transportasi peribadi', 'Sokongan visa perniagaan']),
                'excludes' => json_encode(['Belanja peribadi', 'Makan']),
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }

    private function createVendors(): void
    {
        $vendors = [
            ['name' => 'Hilton Suites Makkah', 'type' => 'hotel', 'contact_person' => 'Omar Hassan', 'email' => 'booking@hiltonmakkah.com', 'phone' => '+966 12 123 4567', 'city' => 'Makkah', 'country' => 'Saudi Arabia', 'rating' => 4.8],
            ['name' => 'Pullman Zamzam Madinah', 'type' => 'hotel', 'contact_person' => 'Ahmed Ali', 'email' => 'info@pullmanmadinah.com', 'phone' => '+966 14 987 6543', 'city' => 'Madinah', 'country' => 'Saudi Arabia', 'rating' => 4.5],
            ['name' => 'Ustaz Ismail bin Rahman', 'type' => 'mutawwif', 'contact_person' => 'Ismail Rahman', 'email' => 'ustaz.ismail@gmail.com', 'phone' => '+60 13 111 2222', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'rating' => 4.9],
            ['name' => 'Saudi Arabian Airlines', 'type' => 'airline', 'contact_person' => 'Sales Team', 'email' => 'groups@saudia.com', 'phone' => '+966 9200 11111', 'city' => 'Jeddah', 'country' => 'Saudi Arabia', 'rating' => 4.2],
            ['name' => 'Al Haramain Express', 'type' => 'transport', 'contact_person' => 'Operations', 'email' => 'ops@alharamain.com', 'phone' => '+966 12 555 6666', 'city' => 'Jeddah', 'country' => 'Saudi Arabia', 'rating' => 4.6],
            ['name' => 'Takaful Malaysia', 'type' => 'insurance', 'contact_person' => 'Nuraini bt Ahmad', 'email' => 'corporate@takaful.com.my', 'phone' => '+60 3 2778 9000', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'rating' => 4.3],
        ];

        foreach ($vendors as $v) {
            Vendor::create($v);
        }
    }

    private function createBookings(): void
    {
        $customers = Customer::with('user')->get();
        $packages = Package::all();

        $statuses = ['inquiry', 'confirmed', 'deposit_paid', 'fully_paid', 'visa_processing', 'visa_approved', 'departed', 'completed', 'cancelled'];

        for ($i = 0; $i < 8; $i++) {
            $customer = $customers[$i % $customers->count()];
            $package = $packages[$i % $packages->count()];
            $status = $statuses[$i % count($statuses)];

            $paxAdults = rand(1, 4);
            $totalAmount = $package->price * $paxAdults;

            $travelDate = now()->addDays(rand(-30, 90));
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'booking_ref' => 'UT-' . strtoupper(Str::random(8)),
                'status' => $status,
                'travel_date' => $travelDate,
                'return_date' => $travelDate->copy()->addDays($package->duration_days),
                'pax_adults' => $paxAdults,
                'pax_children' => rand(0, 2),
                'pax_infants' => rand(0, 1),
                'total_amount' => $totalAmount,
                'paid_amount' => in_array($status, ['fully_paid', 'visa_processing', 'visa_approved', 'departed', 'completed']) ? $totalAmount : ($totalAmount * 0.3),
            ]);

            if (!in_array($status, ['inquiry', 'cancelled'])) {
                $depositAmount = $totalAmount * 0.3;
                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_ref' => 'PAY-' . strtoupper(Str::random(10)),
                    'type' => 'deposit',
                    'amount' => $depositAmount,
                    'method' => ['bank_transfer', 'online', 'cash'][array_rand(['bank_transfer', 'online', 'cash'])],
                    'status' => 'verified',
                    'paid_date' => now()->subDays(rand(5, 30)),
                    'verified_by' => 'admin@usrahtravel.com',
                    'verified_at' => now()->subDays(rand(5, 30)),
                ]);

                if (in_array($status, ['fully_paid', 'visa_processing', 'visa_approved', 'departed', 'completed'])) {
                    Payment::create([
                        'booking_id' => $booking->id,
                        'payment_ref' => 'PAY-' . strtoupper(Str::random(10)),
                        'type' => 'full',
                        'amount' => $totalAmount - $depositAmount,
                        'method' => 'bank_transfer',
                        'status' => 'verified',
                        'paid_date' => now()->subDays(rand(1, 15)),
                        'verified_by' => 'admin@usrahtravel.com',
                        'verified_at' => now()->subDays(rand(1, 15)),
                    ]);
                }

                Invoice::create([
                    'booking_id' => $booking->id,
                    'invoice_no' => 'INV-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'subtotal' => $totalAmount,
                    'tax' => 0,
                    'discount' => $package->discount_price ? ($package->price - $package->discount_price) * $paxAdults : 0,
                    'total' => $package->discount_price ? $package->discount_price * $paxAdults : $totalAmount,
                    'status' => in_array($status, ['fully_paid', 'visa_processing', 'visa_approved', 'departed', 'completed']) ? 'paid' : 'sent',
                    'issue_date' => now()->subDays(rand(10, 45)),
                    'due_date' => now()->addDays(rand(5, 14)),
                ]);
            }

            if (in_array($status, ['departed', 'completed'])) {
                TourGroup::create([
                    'booking_id' => $booking->id,
                    'mutawwif_id' => 3,
                    'group_name' => 'Group ' . chr(65 + $i) . ' - ' . $travelDate->format('M Y'),
                    'flight_no_departure' => 'SV' . rand(800, 999),
                    'flight_no_return' => 'SV' . rand(800, 999),
                    'hotel_makkah' => 'Hilton Suites Makkah',
                    'hotel_madinah' => 'Pullman Zamzam Madinah',
                ]);
            }

            if (!in_array($status, ['inquiry', 'cancelled'])) {
                $docStatuses = ['approved', 'approved', 'pending', 'pending', 'approved'];
                Document::create([
                    'customer_id' => $customer->id,
                    'booking_id' => $booking->id,
                    'type' => 'passport',
                    'file_path' => 'documents/passport_' . $customer->id . '.pdf',
                    'file_name' => 'passport_' . str_replace(' ', '_', $customer->user->name) . '.pdf',
                    'file_size' => '2.4 MB',
                    'status' => $docStatuses[$i % count($docStatuses)],
                    'verified_by' => $docStatuses[$i % count($docStatuses)] === 'approved' ? 'admin@usrahtravel.com' : null,
                    'verified_at' => $docStatuses[$i % count($docStatuses)] === 'approved' ? now()->subDays(rand(3, 20)) : null,
                ]);

                Document::create([
                    'customer_id' => $customer->id,
                    'booking_id' => $booking->id,
                    'type' => ['visa', 'insurance', 'vaccination'][$i % 3],
                    'file_path' => 'documents/' . ['visa', 'insurance', 'vaccination'][$i % 3] . '_' . $customer->id . '.pdf',
                    'file_name' => ['visa', 'insurance', 'vaccination'][$i % 3] . '_' . str_replace(' ', '_', $customer->user->name) . '.pdf',
                    'file_size' => '1.2 MB',
                    'status' => 'pending',
                ]);
            }
        }
    }

    private function createContacts(): void
    {
        $subjects = ['general', 'booking', 'package', 'complaint'];
        $messages = [
            'Saya berminat dengan pakej Umrah. Boleh beri lebih lanjut?',
            'Berapa harga untuk kumpulan 10 orang?',
            'Saya ingin bertanya tentang tarikh penerbangan yang tersedia.',
            'Bolehkah anda sediakan pakej customize untuk syarikat kami?',
            'Terima kasih! Servis yang sangat baik semasa Umrah lepas.',
        ];

        for ($i = 0; $i < 5; $i++) {
            Contact::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'phone' => '+60 ' . rand(10, 19) . '-' . rand(100, 999) . ' ' . rand(1000, 9999),
                'subject' => $subjects[$i % count($subjects)],
                'package_id' => $i % 2 === 0 ? rand(1, 4) : null,
                'message' => $messages[$i],
                'status' => ['new', 'read', 'replied', 'closed', 'new'][$i],
            ]);
        }
    }
}
