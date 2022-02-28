<?php

namespace App\Http\Requests;

use App\BudgetPlan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBudgetPlanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('budget_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:budget_plans,id',
        ];

    }
}
