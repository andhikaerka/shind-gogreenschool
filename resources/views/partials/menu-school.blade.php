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
                @can('home_access')
                    {{--Beranda--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("home") }}">
                            <p>
                                <i class="fas fa-fw fa-home nav-icon"></i>
                                {{ trans('global.home') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('dashboard_access')
                    {{--Dashboard--}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is(''.request()->segment(1).'/') ? 'active' : '' }}"
                           href="{{ route("school.dashboard", ['school_slug' => $school_slug]) }}">
                            <p>
                                <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                                {{ trans('global.dashboard') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('statistic_access')
                    {{--Statistik--}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is(''.request()->segment(1).'/statistics') ? 'active' : '' }}"
                           href="{{ route("school.statistics", ['school_slug' => $school_slug]) }}">
                            <p>
                                <i class="fas fa-fw fa-chart-bar nav-icon"></i>
                                {{ trans('crud.statistics.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('planning_access')
                    {{--Perencanaan--}}
                    <li class="nav-item has-treeview
                    {{ request()->is(''.request()->segment(1).'/show') ? 'menu-open' : '' }}
                    {{ request()->is(''.request()->segment(1).'/edit') ? 'menu-open' : '' }}
                    {{ request()->is('*/infrastructures*') ? 'menu-open' : '' }}
                    {{ request()->is('*/disasters*') ? 'menu-open' : '' }}
                    {{ request()->is('*/quality-reports*') ? 'menu-open' : '' }}
                    {{ request()->is('*/teams*') ? 'menu-open' : '' }}
                    {{ request()->is('*/studies*') ? 'menu-open' : '' }}
                    {{ request()->is('*/curricula*') ? 'menu-open' : '' }}
                    {{ request()->is('*/lesson-plans*') ? 'menu-open' : '' }}
                    {{ request()->is('*/budget-plans*') ? 'menu-open' : '' }}
                    {{ request()->is('*/partners*') ? 'menu-open' : '' }}
                    {{ request()->is('*/work-groups*') ? 'menu-open' : '' }}
                    {{ request()->is('*/cadres*') ? 'menu-open' : '' }}
                    {{ request()->is('*/work-programs*') ? 'menu-open' : '' }}
                    {{ request()->is('*/innovations*') ? 'menu-open' : '' }}
                    {{ request()->is('*/this-year-action-plans*') ? 'menu-open' : '' }}
                    {{ request()->is('*/next-year-action-plans*') ? 'menu-open' : '' }}
                    {{ request()->is('*/account*') ? 'menu-open' : '' }}
                    {{ request()->is('*/environments*') ? 'menu-open' : '' }}
                    {{ request()->is('*/environmental-issues*') ? 'menu-open' : '' }}
                    {{ request()->is('*/extracurriculars*') ? 'menu-open' : '' }}
                    {{ request()->is('*/habituations*') ? 'menu-open' : '' }}

                    ">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.planning.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('account_show')
                                <li class="nav-item">
                                    <a href="{{ route("school.account.show", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/account') || request()->is('*/account/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-user"></i>
                                            {{ trans('crud.account.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('work_group_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.work-groups.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/work-groups') || request()->is('*/work-groups/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-users-cog"></i>
                                            {{ trans('crud.workGroup.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('team_access')
                                {{--Tim Guru LH--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.teams.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/teams') || request()->is('*/teams/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-users"></i>
                                            {{ trans('crud.team.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('school_show')
                                {{--Profil Sekolah--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.show", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is(''.request()->segment(1).'/show') || request()->is(''.request()->segment(1).'/edit') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-school"></i>
                                            {{ trans('crud.school.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('infrastructure_access')
                                {{--Sarpras Sekolah--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.infrastructures.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/infrastructures') || request()->is('*/infrastructures/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-industry"></i>
                                            {{ trans('crud.infrastructure.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('disaster_access')
                                {{--Kebencanaan--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.disasters.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/disasters') || request()->is('*/disasters/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-ambulance"></i>
                                            {{ trans('crud.disaster.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('environmental_issue_access')
                                {{--Kebencanaan--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.environmental-issues.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/environmental-issues') || request()->is('*/environmental-issues/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.environmentalIssue.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('quality_report_access')
                                {{--Raport Mutu--}}
                                {{-- <li class="nav-item">
                                    <a href="{{ route("school.quality-reports.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/quality-reports') || request()->is('*/quality-reports/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.qualityReport.title') }}
                                        </p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route("school.environments.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/environments') || request()->is('*/environments/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.qualityReport.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('curriculum_access')
                                {{--Input KTSP--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.curricula.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/curricula') || request()->is('*/curricula/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-book"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.curriculum.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('lesson_plan_access')
                                {{--Input Silabus RPP--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.lesson-plans.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/lesson-plans') || request()->is('*/lesson-plans/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-book"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.lessonPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('self_development_access')
                            {{--Pelaksanaan Kegiatan--}}
                            <li class="nav-item has-treeview
                            {{ request()->is('*/extracurriculars*') ? 'menu-open' : '' }}
                            {{ request()->is('*/habituations*') ? 'menu-open' : '' }}">
                                <a class="nav-link nav-dropdown-toggle" href="#">
                                    <p>
                                        <i class="fa-fw nav-icon fas fa-cubes"></i>
                                        {{ trans('crud.selfDevelopment.title') }}
                                        <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('extracurricular_access')
                                        {{--Input Kegiatan Sekolah Terkait Lingkungan--}}
                                        <li class="nav-item">
                                            <a href="{{ route("school.extracurriculars.index", ['school_slug' => $school_slug]) }}"
                                               title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.extracurricular.title') }}"
                                               class="nav-link {{ request()->is('*/extracurriculars') || request()->is('*/extracurriculars/*') ? 'active' : '' }}">
                                                <p>
                                                    <i class="fa-fw nav-icon fas fa-tasks"></i>
                                                    {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.extracurricular.title') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('habituation_access')
                                        {{--Input Kegiatan Sekolah Terkait Lingkungan--}}
                                        <li class="nav-item">
                                            <a href="{{ route("school.habituations.index", ['school_slug' => $school_slug]) }}"
                                               title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.habituation.title') }}"
                                               class="nav-link {{ request()->is('*/habituations') || request()->is('*/habituations/*') ? 'active' : '' }}">
                                                <p>
                                                    <i class="fa-fw nav-icon fas fa-tasks"></i>
                                                    {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.habituation.title') }}
                                                </p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan

                            @can('budget_plan_access')
                                {{--Input RKAS--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.budget-plans.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/budget-plans') || request()->is('*/budget-plans/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-book"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.budgetPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('partner_access')
                                {{--Kemitraan Lain--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.partners.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/partners') || request()->is('*/partners/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-hands-helping"></i>
                                            {{ trans('crud.partner.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('cadre_access')
                                {{--Input Kader Siswa--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.cadres.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/cadres') || request()->is('*/cadres/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-user-friends"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.cadre.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('study_access')
                                {{--IPMLH Kajian Lingkungan Sekolah--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.studies.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/studies') || request()->is('*/studies/*') ? 'active' : '' }}"
                                       {{--data-toggle="tooltip" data-placement="right"--}}
                                       title="{{ trans('crud.study.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-graduation-cap"></i>
                                            {{ trans('crud.study.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('innovation_access')
                                {{--Inovasi LH--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.innovations.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/innovations') || request()->is('*/innovations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                                            {{ trans('crud.innovation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('work_program_access')
                                {{--Proker Kader Siswa--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.work-programs.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/work-programs') || request()->is('*/work-programs/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-briefcase"></i>
                                            {{ trans('crud.workProgram.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                            @can('this_year_action_plan_access')
                                {{--Cetak Rencana Aksi Lingkungan Tahun Ini--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.this-year-action-plans.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/this-year-action-plans') || request()->is('*/this-year-action-plans/*') ? 'active' : '' }}"
                                       {{--data-toggle="tooltip" data-placement="right"--}}
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.thisYearActionPlan.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} --}}{{ trans('crud.thisYearActionPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('next_year_action_plan_access')
                                {{--Cetak Rencana Aksi Lingkungan Mendatang--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.next-year-action-plans.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/next-year-action-plans') || request()->is('*/next-year-action-plans/*') ? 'active' : '' }}"
                                       {{--data-toggle="tooltip" data-placement="right"--}}
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActionPlan.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} --}}{{ trans('crud.nextYearActionPlan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('implementation_activity_access')
                    {{--Pelaksanaan Kegiatan--}}
                    <li class="nav-item has-treeview {{ request()->is('*/cadre-activities*') ? 'menu-open' : '' }} {{ request()->is('*/activities*') ? 'menu-open' : '' }} {{ request()->is('*/activity-implementations*') ? 'menu-open' : '' }} {{ request()->is('*/this-year-activity-implementations*') ? 'menu-open' : '' }} {{ request()->is('*/next-year-activity-implementations*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.implementationActivity.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('cadre_activity_access')
                                {{--Input Kegiatan Sekolah Terkait Lingkungan--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.cadre-activities.index", ['school_slug' => $school_slug]) }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.cadreActivity.title') }}"
                                       class="nav-link {{ request()->is('*/cadre-activities') || request()->is('*/cadre-activities/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.cadreActivity.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('activity_access')
                                {{--Input Kegiatan Sekolah Terkait Lingkungan--}}
                                <li class="nav-item">
                                    <a href="{{ route("school.activities.index", ['school_slug' => $school_slug]) }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activity.title') }}"
                                       class="nav-link {{ request()->is('*/activities') || request()->is('*/activities/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{--{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} --}}{{ trans('crud.activity.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--@can('activity_implementation_access')
                                --}}{{--Input Pelaksanaan Kegiatan--}}{{--
                                <li class="nav-item">
                                    <a href="{{ route("school.activity-implementations.index", ['school_slug' => $school_slug]) }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.input') : '' }} {{ trans('crud.activityImplementation.title') }}"
                                       class="nav-link {{ request()->is('*/activity-implementations') || request()->is('*/activity-implementations/*') ? 'active' : '' }}">
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
                                    <a href="{{ route("school.this-year-activity-implementations.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/this-year-activity-implementations') || request()->is('*/this-year-activity-implementations/*') ? 'active' : '' }}"
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
                                    <a href="{{ route("school.next-year-activity-implementations.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/next-year-activity-implementations') || request()->is('*/next-year-activity-implementations/*') ? 'active' : '' }}"
                                       --}}{{--data-toggle="tooltip" data-placement="right"--}}{{--
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActivityImplementation.title') }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-calendar-alt"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.nextYearActivityImplementation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}
                        </ul>
                    </li>
                @endcan
                @can('monitoring_and_evaluation_access')
                    <li class="nav-item has-treeview {{ request()->is('*/monitors*') ? 'menu-open' : '' }} {{ request()->is('*/recommendations*') ? 'menu-open' : '' }} {{ request()->is('*/movement-recommendations*') ? 'menu-open' : '' }} {{ request()->is('*/evaluations*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#"
                           title="{{ trans('crud.monitoringAndEvaluation.title') }}">
                            <p>
                                <i class="fa-fw nav-icon fas fa-tasks"></i>
                                {{ trans('crud.monitoringAndEvaluation.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('monitor_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.monitors.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/monitors') || request()->is('*/monitors/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.monitor.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('evaluation_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.evaluations.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/evaluations') || request()->is('*/evaluations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.evaluation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('recommendation_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.recommendations.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/recommendations') || request()->is('*/recommendations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ trans('crud.recommendation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--@can('movement_recommendation_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.movement-recommendations.index", ['school_slug' => $school_slug]) }}"
                                       title="{{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.movementRecommendation.title') }}"
                                       class="nav-link {{ request()->is('*/movement-recommendations') || request()->is('*/movement-recommendations/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-tasks"></i>
                                            {{ (auth()->user()->isSTC ?? false) ? trans('global.datatables.print') : '' }} {{ trans('crud.movementRecommendation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}
                        </ul>
                    </li>
                @endcan
                @can('verification_access')
                    <li class="nav-item has-treeview {{ request()->is('*/assessment*') ? 'menu-open' : '' }} {{ request()->is('*/assessment-results*') ? 'menu-open' : '' }} {{ request()->is('*/assessment-result-verifications*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <p>
                                <i class="fa-fw nav-icon fas fa-check-double"></i>
                                {{ trans('crud.verification.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('assessment_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.assessments.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/assessments') || request()->is('*/assessments/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                                            {{ trans('crud.assessment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            {{--@can('assessment_result_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.assessment-results.index", ['school_slug' => $school_slug]) }}"
                                       class="nav-link {{ request()->is('*/assessment-results') || request()->is('*/assessment-results/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                                            {{ trans('crud.assessmentResult.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('assessment_result_verification_access')
                                <li class="nav-item">
                                    <a href="{{ route("school.assessment-result-verifications.index", ['school_slug' => $school_slug]) }}"
                                       title="{{ trans('crud.assessmentResultVerification.title') }}"
                                       class="nav-link {{ request()->is('*/assessment-result-verifications') || request()->is('*/assessment-result-verifications/*') ? 'active' : '' }}">
                                        <p>
                                            <i class="fa-fw nav-icon fas fa-check-double"></i>
                                            {{ trans('crud.assessmentResultVerification.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan--}}
                        </ul>
                    </li>
                @endcan

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
                    <li class="nav-item">
                        <a href="#" class="nav-link"
                           onclick="return confirm('{{ trans("global.areYouSure") }}') ? document.getElementById('logoutForm').submit() : false;">
                            <p>
                                <i class="fa-fw nav-icon fas fa-sign-out-alt"></i>
                                {{ trans('global.logout') }}
                            </p>
                        </a>
                    </li>
                @endauth
                <li>
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
                </li>
                <li>
                    &nbsp;
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
