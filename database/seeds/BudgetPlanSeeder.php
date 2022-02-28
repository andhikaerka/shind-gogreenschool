<?php

use App\BudgetPlan;
use Illuminate\Database\Seeder;

class BudgetPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budget_plans = array(
            array('id' => '1', 'school_profile_id' => '1', 'aspect_id' => '1', 'description' => 'BELI AKTIVATOR KOMPOS', 'cost' => '56000', 'snp_category_id' => 5, 'source' => 'BOS', 'pic' => 'KUSMIATI, S.PD', 'created_at' => '2020-08-04 14:08:03', 'updated_at' => '2020-08-04 14:08:03')
        );

        if (is_array($budget_plans) && count($budget_plans)) {
            BudgetPlan::query()->insert($budget_plans);
        }
    }
}
