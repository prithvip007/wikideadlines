<?php

namespace Seeds;

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $california = \App\Models\State::create([
            'name' => 'California',
            'timezone' => 'America/Los_Angeles',
            'preselected' => false
        ]);

        $california->dynamicHolidays()->create([
            'name' => 'Martin Luther King, Jr. Birthday',
            'order' => 3,
            'week_day' => 1,
            'month' => 1
        ]);

        $holidays = [
            [
                'name' => 'New Year\'s Day',
                'date' => '1/1/2019'
            ],
            [
                'name' => 'Lincoln Day',
                'date' => '2/12/2019'
            ],
            [
                'name' => 'Presidents\' Day',
                'date' => '2/18/2019'
            ],
            [
                'name' => 'Cesar Chavez Day',
                'date' => '4/1/2019'
            ],
            [
                'name' => 'Memorial Day',
                'date' => '5/27/2019'
            ],
            [
                'name' => 'Independence Day',
                'date' => '7/4/2019'
            ],
            [
                'name' => 'Labor Day',
                'date' => '9/2/2019'
            ],
            [
                'name' => 'Columbus Day',
                'date' => '10/14/2019'
            ],
            [
                'name' => 'Veterans Day',
                'date' => '11/11/2019'
            ],
            [
                'name' => 'Thanksgiving Day',
                'date' => '11/28/2019'
            ],
            [
                'name' => 'Day After Thanksgiving',
                'date' => '11/29/2019'
            ],
            [
                'name' => 'Christmas Day',
                'date' => '12/25/2019'
            ],
            [
                'name' => 'New Year\'s Day',
                'date' => '1/1/2020'
            ],
            [
                'name' => 'Martin Luther King, Jr. Birthday',
                'date' => '1/20/2020'
            ],
            [
                'name' => 'Lincoln Day',
                'date' => '2/12/2020'
            ],
            [
                'name' => 'Presidents\' Day',
                'date' => '2/17/2020'
            ],
            [
                'name' => 'Cesar Chavez Day',
                'date' => '3/31/2020'
            ],
            [
                'name' => 'Memorial Day',
                'date' => '5/25/2020'
            ],
            [
                'name' => 'Independence Day',
                'date' => '7/3/2020'
            ],
            [
                'name' => 'Labor Day',
                'date' => '9/7/2020'
            ],
            [
                'name' => 'Columbus Day',
                'date' => '10/12/2020'
            ],
            [
                'name' => 'Veterans Day',
                'date' => '11/11/2020'
            ],
            [
                'name' => 'Thanksgiving Day',
                'date' => '11/26/2020'
            ],
            [
                'name' => 'Day After Thanksgiving',
                'date' => '11/27/2020'
            ],
            [
                'name' => 'Christmas Day',
                'date' => '12/25/2020'
            ],
            [
                'name' => "New Year’s Day",
                'date' => "12/31/2021"
            ],
            [
                'name' => "Martin Luther King, Jr.",
                'date' => "01/17/2022"
            ],
            [
                'name' => "Lincoln's Birthday",
                'date' => "02/11/2022"
            ],
            [
                'name' => "Presidents Day",
                'date' => "02/21/2022"
            ],
            [
                'name' => "Caesar Chavez Day",
                'date' => "03/31/2022"
            ],
            [
                'name' => "Memorial Day",
                'date' => "05/30/2022"
            ],
            [
                'name' => "Independence Day",
                'date' => "07/04/2022"
            ],
            [
                'name' => "Labor Day",
                'date' => "09/05/2022"
            ],
            [
                'name' => "Native American Day",
                'date' => "09/23/2022"
            ],
            [
                'name' => "Veterans Day",
                'date' => "11/11/2022"
            ],
            [
                'name' => "Thanksgiving Day",
                'date' => "11/24/2022"
            ],
            [
                'name' => "Day After Thanksgiving",
                'date' => "11/25/2022"
            ],
            [
                'name' => "Christmas Day",
                'date' => "12/26/2022"
            ],
            [
                'name' => "New Year’s Day",
                'date' => "01/02/2023"
            ],
            [
                'name' => "Martin Luther King, Jr.",
                'date' => "01/16/2023"
            ],
            [
                'name' => "Lincoln's Birthday",
                'date' => "02/13/2023"
            ],
            [
                'name' => "Presidents Day",
                'date' => "02/20/2023"
            ],
            [
                'name' => "Caesar Chavez Day",
                'date' => "03/31/2023"
            ],
            [
                'name' => "Memorial Day",
                'date' => "05/29/2023"
            ],
            [
                'name' => "Independence Day",
                'date' => "07/04/2023"
            ],
            [
                'name' => "Labor Day",
                'date' => "09/04/2023"
            ],
            [
                'name' => "Native American Day",
                'date' => "09/22/2023"
            ],
            [
                'name' => "Veterans Day",
                'date' => "11/10/2023"
            ],
            [
                'name' => "Thanksgiving Day",
                'date' => "11/23/2023"
            ],
            [
                'name' => "Day After Thanksgiving",
                'date' => "11/24/2023"
            ],
            [
                'name' => "Christmas Day",
                'date' => "12/25/2023"
            ],
            [
                'name' => "New Year’s Day",
                'date' => "01/01/2024"
            ],
            [
                'name' => "Martin Luther King, Jr.",
                'date' => "01/15/2024"
            ],
            [
                'name' => "Lincoln's Birthday",
                'date' => "02/12/2024"
            ],
            [
                'name' => "Presidents Day",
                'date' => "02/19/2024"
            ],
            [
                'name' => "Caesar Chavez Day",
                'date' => "04/01/2024"
            ],
            [
                'name' => "Memorial Day",
                'date' => "05/27/2024"
            ],
            [
                'name' => "Independence Day",
                'date' => "07/04/2024"
            ],
            [
                'name' => "Labor Day",
                'date' => "09/02/2024"
            ],
            [
                'name' => "Native American Day",
                'date' => "09/27/2024"
            ],
            [
                'name' => "Veterans Day",
                'date' => "11/11/2024"
            ],
            [
                'name' => "Thanksgiving Day",
                'date' => "11/28/2024"
            ],
            [
                'name' => "Day After Thanksgiving",
                'date' => "11/29/2024"
            ],
            [
                'name' => "Christmas Day",
                'date' => "12/25/2024"
            ],
            [
                'name' => "New Year’s Day",
                'date' => "01/01/2025"
            ],
            [
                'name' => "Martin Luther King, Jr.",
                'date' => "01/20/2025"
            ],
            [
                'name' => "Lincoln's Birthday",
                'date' => "02/12/2025"
            ],
            [
                'name' => "Presidents Day",
                'date' => "02/17/2025"
            ],
            [
                'name' => "Caesar Chavez Day",
                'date' => "03/31/2025"
            ],
            [
                'name' => "Memorial Day",
                'date' => "05/26/2025"
            ],
            [
                'name' => "Independence Day",
                'date' => "07/04/2025"
            ],
            [
                'name' => "Labor Day",
                'date' => "09/01/2025"
            ],
            [
                'name' => "Native American Day",
                'date' => "09/26/2025"
            ],
            [
                'name' => "Veterans Day",
                'date' => "11/11/2025"
            ],
            [
                'name' => "Thanksgiving Day",
                'date' => "11/27/2025"
            ],
            [
                'name' => "Day After Thanksgiving",
                'date' => "11/28/2025"
            ],
            [
                'name' => "Christmas Day",
                'date' => "12/25/2025"
            ]
        ];

        foreach($holidays as $holiday) {
            $california->holidays()->create([
                'name' => $holiday['name'],
                'date' =>  \Carbon\Carbon::parse($holiday['date'], $california->timezone)->setTimezone(config('app.timezone'))
            ]);
        }
    }
}
