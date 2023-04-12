<?php

namespace App\Providers;

use App\Exceptions\ApiHandler;
use App\Http\Responses\ApiResponder;
use App\Http\Responses\ResponsesInterface;
use App\Repositories\Reservations\ReservationRepository;
use App\Repositories\Reservations\ReservationRepositoryInterface;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Use the ReservationRepository as the concrete implementation for the ReservationRepositoryInterface
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
