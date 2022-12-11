<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExperienceApplication;

class ExperienceApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ExperienceApplications = ExperienceApplication::create([
            'reason' => '小孩很想養隻狗狗，想先讓他試著學習如何照顧狗狗',
            'experience_id' => 1,
            'user_id' => '81627ded-4e40-4332-b7e8-31fd714b23d1',
        ]);
    }
}
