<?php

namespace App\Http\Controllers\Api;

use App\ChecklistTemplate;
use App\Http\Controllers\Controller;
use App\ParentChecklistTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ChecklistTemplateController extends Controller
{
    public function index(Request $request)
    {
        $cts = array();

        $parentChecklistTemplateQuery = ParentChecklistTemplate::query()
            ->with('checklist_templates');
        if ($request->has('aspect')) {
            $parentChecklistTemplateQuery->whereHas('checklist_templates', function (Builder $builder) use ($request) {
                $builder->where('aspect_id', $request->get('aspect'));
            });
        }
        $parentChecklistTemplates = $parentChecklistTemplateQuery
            ->get();

        foreach ($parentChecklistTemplates as $parentChecklistTemplate) {
            $checklist_templates = array();

            foreach ($parentChecklistTemplate->checklist_templates as $checklist_template) {
                array_push($checklist_templates, array(
                    'id' => $checklist_template->id,
                    'text' => $checklist_template->text
                ));
            }

            array_push($cts, array(
                'isParent' => true,
                'name' => $parentChecklistTemplate->name,
                'selectAll' => $parentChecklistTemplate->select_all,
                'checklistTemplates' => $checklist_templates
            ));
        }

        $checklistTemplateQuery = ChecklistTemplate::query()
            ->whereDoesntHave('parent_checklist_template');
        if ($request->has('aspect')) {
            $checklistTemplateQuery->where('aspect_id', $request->get('aspect'));
        }
        $checklistTemplates = $checklistTemplateQuery
            ->get();

        foreach ($checklistTemplates as $checklistTemplate) {
            array_push($cts, array(
                'isParent' => false,
                'id' => $checklistTemplate->id,
                'text' => $checklistTemplate->text
            ));
        }

        return response()->json($cts);
    }
    public function getByWorkGroup(Request $request)
    {
        $cts = array();
        $school_slug = $request->school_slug;
        $data = \App\Study::with('checklist_templates')
        ->whereHas('work_group.school_profile.school', function ($q) use ($school_slug) {
            $q->where('slug', $school_slug);
        })->where('work_group_id', $request->work_group_id)->get();

        foreach ($data as $study){
            foreach($study->checklist_templates as $value){
                $cts[] = $value->text;
            }
        }

        $lists = array_unique($cts, SORT_REGULAR);
        $response = array();
        $response[0] = ['id' => '', 'text' => trans('global.pleaseSelect')];
        $index = 1;
        foreach ($lists as $key => $value) {
            $response[$index]['id'] = $key;
            $response[$index]['text'] = $value;
            $index++;
        }

        return response()->json($response);
    }
}
