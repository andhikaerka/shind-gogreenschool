<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use \DateTimeInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use Auditable;
    use Notifiable;
    use HasSlug;

    const MAX_LENGTH_OF_NAME = 50;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('username')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('')
            ->doNotGenerateSlugsOnUpdate();
    }

    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'username',
        'approved',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->whereIn('id', [1, 2])->exists();
    }

    public function getIsOperatorAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsSTCAttribute()
    {
        return $this->getIsSchoolAttribute() ? ($this->school->id ?? 0) : ($this->getIsTeamAttribute() ? ($this->team->work_group->school_profile->school->id ?? 0) : ($this->getIsCadreAttribute() ? ($this->cadre->work_group->school_profile->school->id ?? 0) : ($this->getIsWorkGroupAttribute() ? ($this->work_group->school_profile->school->id ?? 0) : false)));
    }

    public function getSchoolSlugAttribute()
    {
        return $this->getIsSchoolAttribute() ? ($this->school->slug ?? 'admin') : ($this->getIsTeamAttribute() ? ($this->team->work_group->school_profile->school->slug ?? 'admin') : ($this->getIsCadreAttribute() ? ($this->cadre->work_group->school_profile->school->slug ?? 'admin') : ($this->getIsWorkGroupAttribute() ? ($this->work_group->school_profile->school->slug ?? 'admin') : 'admin')));
    }

    public function getIsSchoolAttribute()
    {
        return $this->roles()->where('id', 4)->exists() ? ($this->school->id ?? false) : false;
    }

    public function getIsTeamAttribute()
    {
        return $this->roles()->where('id', 5)->exists() ? ($this->team->work_group->school_profile->school_id ?? false) : false;
    }

    public function getIsCadreAttribute()
    {
        return $this->roles()->where('id', 6)->exists() ? ($this->cadre->work_group->school_profile->school_id ?? false) : false;
    }

    public function getIsWorkGroupAttribute()
    {
        return $this->roles()->where('id', 7)->exists() ? ($this->work_group->school_profile->school_id ?? false) : false;
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            $registrationRole = config('panel.registration_default_role');

            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }

        });

    }

    public function school()
    {
        return $this->hasOne(School::class, 'user_id', 'id');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'user_id', 'id');
    }

    public function cadre()
    {
        return $this->hasOne(Cadre::class, 'user_id', 'id');
    }

    public function work_group()
    {
        return $this->hasOne(WorkGroup::class, 'user_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        // $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
        $this->attributes['email_verified_at'] = $value;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
