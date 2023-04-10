<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\City;
use App\Models\Seat;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\TripSegement;
use App\Models\TripTimes;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cities = ['Cairo', 'AlFayyum', 'AlMinya', 'Asyut']; // Add more cities as needed
        foreach ($cities as $city) {
            City::create(['name' => $city]);
        }
        $tripData = [
            'from_city' => 'Cairo',
            'to_city' => 'Asyut',
            'stops' => ['AlFayyum', 'AlMinya']
        ];
        $fromCity = City::where('name', $tripData['from_city'])->firstOrFail();
        $toCity = City::where('name', $tripData['to_city'])->firstOrFail();
        $trip = Trip::create([
            'from_city_id' => $fromCity->id,
            'to_city_id' => $toCity->id,
        ]);
        foreach ($tripData['stops'] as $stopName) {
            $stopCity = City::where('name', $stopName)->firstOrFail();
            $stopCount = Stop::where('trip_id', $trip->id)->count();
            $stopSequence = $stopCount + 1;
            Stop::create([
                'trip_id' => $trip->id,
                'city_id' => $stopCity->id,
                'stop_sequence' => $stopSequence,
            ]);
        }
        $busData = [
            'name' => 'Bus 1',
            'seats' => 12,
        ];

        $bus = Bus::create([
            'trip_id' => $trip->id,
            'available_seats' => $busData['seats'],
        ]);
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => bcrypt('123456789')

            ],
            [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com',
                'password' => bcrypt('123456789')
            ],
        ];

        foreach ($users as $userData) {
            $users = User::create($userData);
        }

        for ($i = 1; $i <= $busData['seats']; $i++) {
            $seats = Seat::create([
                'bus_id' => $bus->id,
                'number' => $i,
            ]);
        }
        $users = User::all();
        $seats = Seat::all();
        foreach ($seats as $seat) {
            Booking::create([
                'user_id' => $users->random()->id,
                'seat_id' => $seat->id,
            ]);
        }
    }
}
