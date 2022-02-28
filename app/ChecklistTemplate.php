<?php

namespace App;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ChecklistTemplate extends Model
{
    use Auditable;
    use HasSlug;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('text')
            ->saveSlugsTo('slug');
    }

    public $table = 'checklist_templates';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'aspect_id',
        'parent_checklist_template_id',
        'slug',
        'text',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class);
    }

    public function parent_checklist_template()
    {
        return $this->belongsTo(ParentChecklistTemplate::class);
    }

    public function studies()
    {
        return $this->belongsToMany(Study::class);
    }
}
