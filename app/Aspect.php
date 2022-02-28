<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Aspect extends Model
{
    use Auditable;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public $table = 'aspects';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'slug',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function aspectInfrastructures()
    {
        return $this->hasMany(Infrastructure::class);
    }

    public function aspectLessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function aspectBudgetPlans()
    {
        return $this->hasMany(BudgetPlan::class);
    }

    public function workGroups()
    {
        return $this->hasMany(workGroup::class);
    }
}
