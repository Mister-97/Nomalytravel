<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    // Only confirmed-working image URLs (verified from live renders this session)
    private const IMG = [
        'suv_white'   => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=480&q=80',   // white Honda CR-V crossover
        'suv_dark'    => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=480&q=80',   // dark SUV
        'suv_desert'  => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=480&q=80',   // white SUV desert
        'sedan'       => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=480&q=80',      // white sedan
        'compact_red' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=480&q=80',      // red compact
        'luxury'      => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=480&q=80',      // white BMW luxury
        'sports'      => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=480&q=80',      // blue Camaro
        'convertible' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=480&q=80',   // convertible
        'mustang'     => 'https://images.unsplash.com/photo-1547245324-d777c6f05e80?w=480&q=80',      // Mustang
        'pickup'      => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?w=480&q=80',
    ];

    private static $catalog = [
        ['category'=>'Economy',      'name'=>'Toyota Yaris',     'base'=>28,  'seats'=>4, 'img'=>'compact_red'],
        ['category'=>'Economy',      'name'=>'Kia Rio',          'base'=>26,  'seats'=>4, 'img'=>'sedan'],
        ['category'=>'Economy',      'name'=>'Nissan Versa',     'base'=>29,  'seats'=>5, 'img'=>'compact_red'],
        ['category'=>'Compact',      'name'=>'Honda Civic',      'base'=>35,  'seats'=>5, 'img'=>'sedan'],
        ['category'=>'Compact',      'name'=>'Toyota Corolla',   'base'=>33,  'seats'=>5, 'img'=>'sedan'],
        ['category'=>'Compact',      'name'=>'Hyundai Elantra',  'base'=>32,  'seats'=>5, 'img'=>'compact_red'],
        ['category'=>'Midsize',      'name'=>'Toyota Camry',     'base'=>45,  'seats'=>5, 'img'=>'sedan'],
        ['category'=>'Midsize',      'name'=>'Honda Accord',     'base'=>47,  'seats'=>5, 'img'=>'sedan'],
        ['category'=>'Midsize',      'name'=>'Chevrolet Malibu', 'base'=>43,  'seats'=>5, 'img'=>'sedan'],
        ['category'=>'SUV',          'name'=>'Ford Explorer',    'base'=>65,  'seats'=>7, 'img'=>'suv_dark'],
        ['category'=>'SUV',          'name'=>'Chevy Tahoe',      'base'=>72,  'seats'=>8, 'img'=>'suv_desert'],
        ['category'=>'SUV',          'name'=>'Toyota 4Runner',   'base'=>68,  'seats'=>7, 'img'=>'suv_dark'],
        ['category'=>'Crossover',    'name'=>'Honda CR-V',       'base'=>55,  'seats'=>5, 'img'=>'suv_white'],
        ['category'=>'Crossover',    'name'=>'Toyota RAV4',      'base'=>57,  'seats'=>5, 'img'=>'suv_white'],
        ['category'=>'Crossover',    'name'=>'Nissan Rogue',     'base'=>52,  'seats'=>5, 'img'=>'suv_white'],
        ['category'=>'Minivan',      'name'=>'Chrysler Pacifica','base'=>75,  'seats'=>7, 'img'=>'suv_desert'],
        ['category'=>'Minivan',      'name'=>'Toyota Sienna',    'base'=>78,  'seats'=>8, 'img'=>'suv_white'],
        ['category'=>'Van',          'name'=>'Ford Transit',     'base'=>85,  'seats'=>12,'img'=>'suv_dark'],
        ['category'=>'Luxury',       'name'=>'BMW 5 Series',     'base'=>95,  'seats'=>5, 'img'=>'luxury'],
        ['category'=>'Luxury',       'name'=>'Mercedes E-Class', 'base'=>105, 'seats'=>5, 'img'=>'luxury'],
        ['category'=>'Luxury',       'name'=>'Cadillac CT5',     'base'=>98,  'seats'=>5, 'img'=>'luxury'],
        ['category'=>'Pickup Truck', 'name'=>'Ford F-150',       'base'=>55,  'seats'=>5, 'img'=>'pickup'],
        ['category'=>'Pickup Truck', 'name'=>'Chevy Silverado',  'base'=>58,  'seats'=>5, 'img'=>'pickup'],
        ['category'=>'Pickup Truck', 'name'=>'RAM 1500',         'base'=>56,  'seats'=>5, 'img'=>'pickup'],
        ['category'=>'Convertible',  'name'=>'Ford Mustang',     'base'=>85,  'seats'=>4, 'img'=>'mustang'],
        ['category'=>'Convertible',  'name'=>'Chevy Camaro',     'base'=>88,  'seats'=>4, 'img'=>'sports'],
        ['category'=>'Sports',       'name'=>'Dodge Charger',    'base'=>80,  'seats'=>5, 'img'=>'sports'],
        ['category'=>'Sports',       'name'=>'Mazda MX-5 Miata', 'base'=>72,  'seats'=>2, 'img'=>'convertible'],
    ];

    private static $companies = [
        'Hertz','Enterprise','Avis','Budget','Dollar','National','Alamo','Thrifty','Sixt','Payless',
    ];

    public function search(Request $request)
    {
        $pickup   = trim($request->input('pickup', ''));
        $checkin  = $request->input('checkin', '');
        $checkout = $request->input('checkout', '');
        $age      = (int) $request->input('age', 30);

        if (!$pickup)   return response()->json(['error' => 'Pick-up location is required.'], 422);
        if (!$checkin)  return response()->json(['error' => 'Pick-up date is required.'], 422);
        if (!$checkout) return response()->json(['error' => 'Return date is required.'], 422);

        try {
            $from = new \DateTime($checkin);
            $to   = new \DateTime($checkout);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid dates.'], 422);
        }

        $days   = max(1, (int) $from->diff($to)->days);
        $hash   = abs(crc32(strtolower($pickup)));
        $factor = 1.0 + ((($hash % 31) - 15) / 100.0);

        $catalog   = self::$catalog;
        $companies = self::$companies;
        shuffle($catalog);
        shuffle($companies);
        $selected = array_slice($catalog, 0, 8);

        $bookingUrl = 'https://www.awin1.com/cread.php?awinmid=18808&awinaffid=2836196&ued='
                    . urlencode('https://www.rentalcars.com/');

        $cars = [];
        foreach ($selected as $i => $car) {
            $jitter = 1.0 + (rand(-8, 8) / 100.0);
            $ppd    = (int) round($car['base'] * $factor * $jitter);
            $total  = $ppd * $days;
            $cars[] = [
                'name'         => $car['name'],
                'category'     => $car['category'],
                'company'      => $companies[$i % count($companies)],
                'price_per_day'=> $ppd,
                'total_price'  => $total,
                'days'         => $days,
                'seats'        => $car['seats'],
                'transmission' => 'Automatic',
                'image'        => self::IMG[$car['img']],
                'booking_url'  => $bookingUrl,
            ];
        }

        return response()->json(['cars' => $cars]);
    }
}
