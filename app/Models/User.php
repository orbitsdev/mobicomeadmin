<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Student;
use App\Models\Teacher;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getFullName(){
        return ($this->first_name ?? '') . ' ' . ($this->last_name ?? '');
    }
    public function getImage(){

        if(!empty($this->profile_photo_path)){
            return Storage::disk('public')->url($this->profile_photo_path);

        }else{
            return "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80";
        }
    }

    public function teacher(){
        return $this->hasOne(Teacher::class,);
    }
    public function student(){
        return $this->hasOne(Student::class,);
    }

    public function isAdmin(){
        return $this->role == 'Admin';
    }
    public function isTeacher(){
        return $this->role == 'Teacher';
    }

    public function isStudent(){
        return $this->role == 'Student';
    }

    public function redirectBasedOnRole()
    {
        switch ($this->role) {
            case 'Admin':
                return redirect()->route('list-users');
                break;
            case 'Teacher':
                if($this->teacher){

                    return redirect()->route('teacher-list-excercises');
                }else{
                    return redirect()->route('no-page');
                }

                break;
            case 'Student':
                return redirect()->route('no-page');
                break;
            default:
                return redirect()->route('no-page');
        }
    }

    public function excercises(){
        return $this->hasMany(Excercise::class);
    }

    // {{
    //     $routeName = \Route::currentRouteName();

    // }}

}
