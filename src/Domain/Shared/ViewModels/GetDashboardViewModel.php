<?php

namespace Domain\Shared\ViewModels;

use Domain\Subscriber\DataTransferObjects\NewSubscribersCountData;

class GetDashboardViewModel extends ViewModel
{
    public function newSubscribersCount(): NewSubscribersCountData
    {
        return new NewSubscribersCountData(
            total: 0,
            this_month: 0,
            this_week: 0,
            today: 0,
        );
    }
}