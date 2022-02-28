<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class BudgetPlan extends Model
{
    use Auditable;
    use Activable;

    public $table = 'budget_plans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'aspect_id',
        'description',
        'cost',
        'snp_category_id',
        'source',
        'pic',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_DESCRIPTION = 100;
    const MAX_LENGTH_OF_SOURCE = 100;
    const MAX_LENGTH_OF_PIC = 35;

    const SOURCE_SELECT = [
        'BOS' => 'BOS',
        'BOS NAS' => 'BOS NAS',
        'BOSDA' => 'BOSDA',
        'Komite' => 'Komite',
        'Sponsor' => 'Sponsor',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class, 'aspect_id');
    }

    public function snp_category()
    {
        return $this->belongsTo(SnpCategory::class, 'snp_category_id');
    }
}
