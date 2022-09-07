<?php

namespace Deyji\Manage\Models;

use Deyji\Manage\PermissionRegistrar;
use Deyji\Manage\Models\Privilege\Role;
use Deyji\Manage\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Student;
use App\Models\Staff;
use Deyji\Manage\Models\Maps;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'password',
        'email',
        'image',
        'gender',
        'emergency_contact_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function map()
    {
        return $this->hasOne(Maps::class);
    }
    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }
    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    public function deleteStudentRecord()
    {
        $this->student()->delete();
        // $this->staff()->delete();
        return parent::delete();
    }
}
