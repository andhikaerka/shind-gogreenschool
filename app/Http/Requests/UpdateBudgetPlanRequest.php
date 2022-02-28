<?php

namespace App\Http\Requests;

use App\BudgetPlan;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBudgetPlanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('budget_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'aspect_id' => ['required', 'exists:aspects,id'],
            'description' => ['required', 'string', 'max:' . BudgetPlan::MAX_LENGTH_OF_DESCRIPTION],
            'cost' => ['required', 'integer', 'min:0', 'max:2147483647'],
            'snp_category_id' => ['required', 'exists:snp_categories,id'],
            'source' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'pic' => ['required', 'string', 'max:' . BudgetPlan::MAX_LENGTH_OF_PIC],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.budgetPlan.fields.school')),
            'aspect_id' => strtolower(trans('crud.budgetPlan.fields.aspect')),
            'description' => strtolower(trans('crud.budgetPlan.fields.description')),
            'cost' => strtolower(trans('crud.budgetPlan.fields.cost')),
            'snp_category_id' => strtolower(trans('crud.budgetPlan.fields.category')),
            'source' => strtolower(trans('crud.budgetPlan.fields.source')),
            'pic' => strtolower(trans('crud.budgetPlan.fields.pic')),
        ];
    }
}
