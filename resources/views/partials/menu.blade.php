<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{--<!-- Brand Logo -->--}}
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    {{--<!-- Sidebar -->--}}
    <div class="sidebar">
        {{--<!-- Sidebar Menu -->--}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{--Beranda--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("home") }}">
                        <p>
                            <i class="fas fa-fw fa-home nav-icon"></i>
                            {{ trans('global.home') }}
                        </p>
                    </a>
                </li>
                {{--Dashboard--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}"
                       href="{{ route("admin.dashboard") }}">
                        <p>
                            <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                {{--Statistik--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/statistic') ? 'active' : '' }}"
                       href="{{ route("admin.statistic") }}">
                        <p>
                            <i class="fas fa-fw fa-chart-area nav-icon"></i>
                            Statistik
                        </p>
                    </a>
                </li>
                {{--Sekolah--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/schools') ? 'active' : '' }} {{ request()->is('admin/schools/*') ? 'active' : '' }}"
                       href="{{ route("admin.schools.index") }}">
                        <p>
                            <i class="fas fa-fw fa-building nav-icon"></i>
                            Sekolah
                        </p>
                    </a>
                </li>
                {{--Penilaian--}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/assessments') ? 'active' : '' }} {{ request()->is('admin/assessments/*') ? 'active' : '' }}"
                       href="{{ route("admin.assessments.index") }}">
                        <p>
                            <i class="fas fa-fw fa-file nav-icon"></i>
                            Penilaian
                        </p>
                    </a>
                </li>
                {{--@can('planning_access')
                    --}}{{--Perencanaan--}}{{--
                    <li class="nav-item has-treeview {{ request()->is('admin/schools*') ? 'menu-open' : '' }} {{ request()->is('admin/infrastructures*') ? 'menu-open' : '' }} {{ request()->is('admin/disasters*') ? 'menu-open' : '' }} {{ request()->is('admin/quality-reports*') ? 'menu-open' : '' }} {{ request()->is('admin/teams*') ? 'menu-open' : '' }} {{ request()->is('admin/studies*') ? 'menu-open' : '' }} {{ request()->is('admin/lesson-plans*') ? 'menu-open' : '' }} {{ request()->is('admin/budget-plans*') ? 'menu-open' : '' }} {{ request()->is('admin/partners*') ? 'menu-open' : '' }} {{ request()->is('admin/work-groups*') ? 'menu-open' : '' }} {{ request()->is('admin/cadres*') ? 'menu-open' : '' }} {{ request()->is('admin/work-programs*') ? 'menu-open' : '' }} {{ request()->is('admin/this-year-action-plans*') ? 'menu-open' : '' }} {{ request()->is('admin/next-year-action-plans*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.planning.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('school_access')
                                --}}{{--Profil Sekolah--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.schools.index") }}"
                                       class="nav-link {{ request()->is('admin/schools') || request()->is('admin/schools/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-school"></i>
                                            {{ trans('crud.school.title') }}
                                        </p>
                                    </a>
                                </li>
                            @elseif(auth()->user()->isSTC ?? false)
                                --}}{{--Profil Sekolah--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.schools.show", ['school' => (auth()->user()->isSTC ?? false)]) }}"
                                       class="nav-link {{ request()->is('admin/schools') || request()->is('admin/schools/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-school"></i>
                                            {{ trans('crud.school.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('infrastructure_access')
                                --}}{{--Sarpras Sekolah--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.infrastructures.index") }}"
                                       class="nav-link {{ request()->is('admin/infrastructures') || request()->is('admin/infrastructures/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-industry"></i>
                                            {{ trans('crud.infrastructure.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('disaster_access')
                                --}}{{--Kebencanaan--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.disasters.index") }}"
                                       class="nav-link {{ request()->is('admin/disasters') || request()->is('admin/disasters/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-ambulance"></i>
                                            {{ trans('crud.disaster.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('quality_report_access')
                                --}}{{--Raport Mutu--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.quality-reports.index") }}"
                                       class="nav-link {{ request()->is('admin/quality-reports') || request()->is('admin/quality-reports/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.qualityReport.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('team_access')
                                --}}{{--Tim Guru LH--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.teams.index") }}"
                                       class="nav-link {{ request()->is('admin/teams') || request()->is('admin/teams/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-users"></i>
                                            {{ trans('crud.team.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('study_access')
                                --}}{{--IPMLH Kajian Lingkungan Sekolah--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.studies.index") }}"
                                       class="nav-link {{ request()->is('admin/studies') || request()->is('admin/studies/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ trans('crud.study.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-graduation-cap"></i>
                                            {{ trans('crud.study.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('lesson_plan_access')
                                --}}{{--Input Silabus RPP KTSP--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.lesson-plans.index") }}"
                                       class="nav-link {{ request()->is('admin/lesson-plans') || request()->is('admin/lesson-plans/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-book"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.lessonPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('budget_plan_access')
                                --}}{{--Input RKAS--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.budget-plans.index") }}"
                                       class="nav-link {{ request()->is('admin/budget-plans') || request()->is('admin/budget-plans/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-book"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.budgetPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('partner_access')
                                --}}{{--Kemitraan Lain--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.partners.index") }}"
                                       class="nav-link {{ request()->is('admin/partners') || request()->is('admin/partners/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-hands-helping"></i>
                                            {{ trans('crud.partner.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            --}}{{--@can('work_group_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.work-groups.index") }}"
                                       class="nav-link {{ request()->is('admin/work-groups') || request()->is('admin/work-groups/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-users-cog">

                                        </i>
                                        <p>
                                            {{ trans('crud.workGroup.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}{{--
                            @can('cadre_access')
                                --}}{{--Input Kader Siswa--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.cadres.index") }}"
                                       class="nav-link {{ request()->is('admin/cadres') || request()->is('admin/cadres/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-user-friends"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.cadre.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('work_program_access')
                                --}}{{--Proker Kader Siswa--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.work-programs.index") }}"
                                       class="nav-link {{ request()->is('admin/work-programs') || request()->is('admin/work-programs/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                                            {{ trans('crud.workProgram.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('this_year_action_plan_access')
                                --}}{{--Cetak Rencana Aksi Lingkungan Tahun Ini--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.this-year-action-plans.index") }}"
                                       class="nav-link {{ request()->is('admin/this-year-action-plans') || request()->is('admin/this-year-action-plans/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.thisYearActionPlan.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.thisYearActionPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('next_year_action_plan_access')
                                --}}{{--Cetak Rencana Aksi Lingkungan Mendatang--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.next-year-action-plans.index") }}"
                                       class="nav-link {{ request()->is('admin/next-year-action-plans') || request()->is('admin/next-year-action-plans/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActionPlan.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActionPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan--}}
                {{--@can('implementation_activity_access')
                    --}}{{--Pelaksanaan Kegiatan--}}{{--
                    <li class="nav-item has-treeview {{ request()->is('admin/activities*') ? 'menu-open' : '' }} {{ request()->is('admin/activity-implementations*') ? 'menu-open' : '' }} {{ request()->is('admin/this-year-activity-implementations*') ? 'menu-open' : '' }} {{ request()->is('admin/next-year-activity-implementations*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.implementationActivity.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('activity_access')
                                --}}{{--Input Kegiatan Sekolah Terkait Lingkungan--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.activities.index") }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activity.title') }}"
                                       class="nav-link {{ request()->is('admin/activities') || request()->is('admin/activities/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activity.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('activity_implementation_access')
                                --}}{{--Input Pelaksanaan Kegiatan--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.activity-implementations.index") }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activityImplementation.title') }}"
                                       class="nav-link {{ request()->is('admin/activity-implementations') || request()->is('admin/activity-implementations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activityImplementation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('this_year_activity_implementation_access')
                                --}}{{--Cetak Rencana Aksi Lingkungan Tahun Ini--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.this-year-activity-implementations.index") }}"
                                       class="nav-link {{ request()->is('admin/this-year-activity-implementations') || request()->is('admin/this-year-activity-implementations/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.thisYearActivityImplementation.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.thisYearActivityImplementation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('next_year_activity_implementation_access')
                                --}}{{--Cetak Rencana Aksi Lingkungan Mendatang--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("admin.next-year-activity-implementations.index") }}"
                                       class="nav-link {{ request()->is('admin/next-year-activity-implementations') || request()->is('admin/next-year-activity-implementations/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActivityImplementation.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActivityImplementation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan--}}
                {{--@can('monitoring_and_evaluation_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/monitoring-progresses*') ? 'menu-open' : '' }} {{ request()->is('admin/recommendations*') ? 'menu-open' : '' }} {{ request()->is('admin/movement-recommendations*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#"
                           title="{{ trans('crud.monitoringAndEvaluation.title') }}">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.monitoringAndEvaluation.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('monitoring_progress_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.monitoring-progresses.index") }}"
                                       class="nav-link {{ request()->is('admin/monitoring-progresses') || request()->is('admin/monitoring-progresses/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.monitoringProgress.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('recommendation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.recommendations.index") }}"
                                       class="nav-link {{ request()->is('admin/recommendations') || request()->is('admin/recommendations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.recommendation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('movement_recommendation_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.movement-recommendations.index") }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.movementRecommendation.title') }}"
                                       class="nav-link {{ request()->is('admin/movement-recommendations') || request()->is('admin/movement-recommendations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.movementRecommendation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan--}}
                {{--@can('assessment_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/assessment-results*') ? 'menu-open' : '' }} {{ request()->is('admin/assessment-result-verifications*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-check-double"></i>
                                {{ trans('crud.assessment.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('assessment_result_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assessment-results.index") }}"
                                       class="nav-link {{ request()->is('admin/assessment-results') || request()->is('admin/assessment-results/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                                            {{ trans('crud.assessmentResult.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('assessment_result_verification_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assessment-result-verifications.index") }}"
                                       title="{{ trans('crud.assessmentResultVerification.title') }}"
                                       class="nav-link {{ request()->is('admin/assessment-result-verifications') || request()->is('admin/assessment-result-verifications/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                                            {{ trans('crud.assessmentResultVerification.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan--}}
                {{--@can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-users"></i>
                                {{ trans('crud.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}"
                                       class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-unlock-alt"></i>
                                            {{ trans('crud.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}"
                                       class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                                            {{ trans('crud.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}"
                                       class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-user"></i>
                                            {{ trans('crud.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan--}}
                @can('setting_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/banners*') ? 'menu-open' : '' }} {{ request()->is('admin/disaster-threats*') ? 'menu-open' : '' }} {{ request()->is('admin/curriculum-calendars*') ? 'menu-open' : '' }} {{ request()->is('admin/provinces*') ? 'menu-open' : '' }} {{ request()->is('admin/cities*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-cogs"></i>
                                {{ trans('crud.setting.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('banner_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.banners.index") }}"
                                       class="nav-link {{ request()->is('admin/banners') || request()->is('admin/banners/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-images"></i>
                                            {{ trans('crud.banner.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--@can('disaster_threat_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.disaster-threats.index") }}"
                                       class="nav-link {{ request()->is('admin/disaster-threats') || request()->is('admin/disaster-threats/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-exclamation-triangle"></i>
                                            {{ trans('crud.disasterThreat.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}
                            @can('curriculum_calendar_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.curriculum-calendars.index") }}"
                                       class="nav-link {{ request()->is('admin/curriculum-calendars') || request()->is('admin/curriculum-calendars/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ trans('crud.curriculumCalendar.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--@can('province_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.provinces.index") }}"
                                       class="nav-link {{ request()->is('admin/provinces') || request()->is('admin/provinces/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-map"></i>
                                            {{ trans('crud.province.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('city_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cities.index") }}"
                                       class="nav-link {{ request()->is('admin/cities') || request()->is('admin/cities/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-building"></i>
                                            {{ trans('crud.city.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}
                            @auth
                                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                                    @can('profile_password_edit')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                                               href="{{ route('profile.password.edit') }}">
                                                <p>
                                                    <i class="fa-fw nav-icon fas fa-key"></i>
                                                    {{ trans('global.change_password') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                @endif
                                {{--<li class="nav-item">
                                    <a href="#" class="nav-link"
                                       onclick="return confirm('{{ trans("global.areYouSure") }}') ? document.getElementById('logoutForm').submit() : false;">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-sign-out-alt"></i>
                                            {{ trans('global.logout') }}
                                        </p>
                                    </a>
                                </li>--}}
                            @endauth
                        </ul>
                    </li>
                @endcan

                {{--<li>
                    <div class="m-1 p-1 border">
                        <div id="carouselBannerSlidesOnly" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach(\App\Banner::all() as $bKey => $b)
                                    @if($b->image)
                                        <div class="carousel-item {{ $bKey == 0 ? 'active' : '' }}">
                                            <img src="{{ $b->image->getUrl() }}" class="d-block w-100" alt="...">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>--}}
                <li>
                    &nbsp;
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
