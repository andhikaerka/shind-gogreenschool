<?php

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
        $this->call([
            PermissionSeeder::class,
            AdditionalPermissionSeeder::class,
            RoleSeeder::class,
            PermissionRoleTableSeeder::class,
            UserSeeder::class,
            RoleUserTableSeeder::class,

            AspectSeeder::class,
            SnpCategorySeeder::class,
            DisasterThreatSeeder::class,
            CurriculumCalendarSeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,
            EnvironmentalStatusSeeder::class,
            TeamStatusSeeder::class,
            TeamPositionSeeder::class,
            ParentChecklistTemplateSeeder::class,
            ChecklistTemplateSeeder::class,
            WorkGroupNameSeeder::class,
            PartnerCategorySeeder::class,
            PartnerActivitySeeder::class,

            BannerSeeder::class,

            MediaSeeder::class,

            SchoolSeeder::class,
            SchoolProfileSeeder::class,
            WorkGroupSeeder::class,
            InfrastructureSeeder::class,
            DisasterSeeder::class,
            QualityReportSeeder::class,
            TeamSeeder::class,
            PartnerSeeder::class,
            StudySeeder::class,
            ChecklistTemplateStudyTableSeeder::class,
            StudyTeamStatusTableSeeder::class,
            CurriculumSeeder::class,
            CurriculumCurriculumCalendarTableSeeder::class,
            LessonPlanSeeder::class,
            BudgetPlanSeeder::class,
            CadreSeeder::class,
            WorkProgramSeeder::class,
            InnovationSeeder::class,
            InnovationTeamStatusTableSeeder::class,
            ActivitySeeder::class,
            ActivityTeamStatusTableSeeder::class,
            CadreActivitySeeder::class,
            CadreActivityTeamStatusTableSeeder::class,
            MonitorSeeder::class,
            RecommendationSeeder::class,
            AssessmentSeeder::class,

        ]);
    }
}
