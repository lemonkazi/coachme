<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        \App\Models\User::factory(1)->create([
            'email' => 'sadmin@coach.com',
            'name' => 'sadmin',
        ]);


        //\App\Models\User::factory(10)->create();
        // \App\Models\User::factory(1)->create([
        //     'email' => 'sadmin@coach.com',
        //     'name' => 'sadmin',
        //     'authority' => 'SUPER_ADMIN',
        // ]);
        //\App\Models\User::factory(10)->create();

        // \App\Models\Rink::factory(3)
        //     ->create()
        //     ->each(function ($rink) {
        //         \App\Models\User::factory(1)->create([
        //             'name' => 'rink_user',
        //             'rink_id' => $rink->id,
        //             'email' => 'rink_user@coach.com',
        //             'authority' => 'RINK_USER',
        //         ]);
        //         \App\Models\User::factory(2)->create([
        //             'rink_id' => $rink->id,
        //             'authority' => 'RINK_USER',
        //         ]);

                /* $building->companies()->createMany(factory(App\Models\Company::class, 10)->make()->toArray())->each(function ($company) use ($building) {
                    $company->floors()->createMany(factory(App\Models\CompanyFloor::class, 2)->make([
                        'company_id' => $company->id,
                    ])->toArray());
                    
                    factory(App\Models\User::class, 20)->create([
                        'company_id' => $company->id,
                        'authority' => 'USER',
                    ]);
                }); */

                // $building->shops()->createMany(factory(App\Models\Shop::class, 20)->make()->toArray())->each(function ($shop) {
                //     factory(App\Models\User::class, 1)->create([
                //         'shop_id' => $shop->id,
                //         'email' => 'shopadmin@wc.com',
                //         'authority' => 'CITY_ADMIN',
                //     ]);

                //     factory(App\Models\User::class, 2)->create([
                //         'shop_id' => $shop->id,
                //         'authority' => 'CITY_ADMIN',
                //     ]);
                // });
            //});
    }
}
