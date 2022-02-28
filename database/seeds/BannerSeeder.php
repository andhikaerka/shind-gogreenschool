<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = array(
            array('id' => '1', 'slug' => 'banner-pesan-lh-dari-adminoperator', 'title' => 'Banner Pesan LH dari admin/operator', 'created_at' => '2020-08-04 07:55:49', 'updated_at' => '2020-08-04 07:55:49')
        );

        if (is_array($banners) && count($banners)) {
            Banner::query()->insert($banners);
        }
    }
}
