<?php

namespace App\Http\Controllers\Api;

use App\ChecklistTemplate;
use App\Http\Controllers\Controller;
use App\ParentChecklistTemplate;
use App\Study;
use App\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index(Request $request)
    {
        $studies = Study::query()
            ->with('studyWorkPrograms')
            ->selectRaw("id, CONCAT('
            " . (trans('crud.study.fields.potential')) . ": ', potential, ';
            " . (trans('crud.study.fields.problem')) . ": ', problem, ';
            " . (trans('crud.study.fields.behavioral')) . ": ', behavioral, ';
            " . (trans('crud.study.fields.physical')) . ": ', physical, ';
            " . (trans('crud.study.fields.artwork')) . ": ', artwork, ';
            " . (trans('crud.study.fields.period')) . ": ', period, ' Bulan') AS text, activity")
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                if ($request->get('school')) {
                    $builder->where('school_id', $request->get('school'));
                }
            })
            ->where('work_group_id', $request->get('work_group'))
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($studies);
    }

    public function show(Request $request)
    {
        $study = Study::query()->find($request->get('study'));
        $cts = array();

        if ($study && $study->id) {
            $pcs = ParentChecklistTemplate::query()
                ->whereHas('checklist_templates.studies', function (Builder $builder) use ($study) {
                    $builder->where('study_id', $study->id);
                })
                ->get();
            foreach ($pcs as $pc) {
                $checklist_templates = array();

                foreach ($pc->checklist_templates as $checklist_template) {
                    if (ChecklistTemplate::query()
                        ->where('id', $checklist_template->id)
                        ->whereHas('studies', function (Builder $builder) use ($study) {
                            $builder->where('study_id', $study->id);
                        })
                        ->exists()) {
                        array_push($checklist_templates, array(
                            'id' => $checklist_template->id,
                            'text' => $checklist_template->text
                        ));
                    }
                }

                array_push($cts, array(
                    'isParent' => true,
                    'name' => $pc->name,
                    'selectAll' => $pc->select_all,
                    'checklistTemplates' => $checklist_templates
                ));
            }

            $checklistTemplateQuery = ChecklistTemplate::query()
                ->whereDoesntHave('parent_checklist_template')
                ->whereHas('studies', function (Builder $builder) use ($study) {
                    $builder->where('study_id', $study->id);
                });
            $checklistTemplates = $checklistTemplateQuery
                ->get();
            foreach ($checklistTemplates as $checklistTemplate) {
                array_push($cts, array(
                    'isParent' => false,
                    'id' => $checklistTemplate->id,
                    'text' => $checklistTemplate->text
                ));
            }
        }

        return response()->json(['study' => $study, 'cts' => $cts]);
    }
    public function checkPercentage(Request $request){
        School::query()->where('slug', $request->school_slug)->firstOrFail();
        $maxPercentage = Study::MAX_PERCENTAGE;
        $percentageAmountNow = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('slug', $request->school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($request) {
                $builder->where('aspect_id', $request->aspect_id);
            })
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;
        return response()->json(['maxPercentage' => $maxPercentage]);
    }
}
