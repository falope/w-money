<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;
use App\Events\UpdatedResetPassword;
use App\Events\ActivatedInvestment;
use App\Listeners\SendRegistrationMail;
use App\Listeners\UpdateUserReferrals;
use App\Listeners\SendResetPasswordMail;
use App\Listeners\RecordInvestmentReferralEarning;
use App\Listeners\CreateReferralTransaction;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            UpdateUserReferrals::class,
            SendRegistrationMail::class,
            CreateReferralTransaction::class,
        ],
        ActivatedInvestment::class => [
            RecordInvestmentReferralEarning::class
        ],
        UpdatedResetPassword::class => [
            SendResetPasswordMail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
