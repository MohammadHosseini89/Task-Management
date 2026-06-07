<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\MyTeams;
use App\Models\LoginHistory;
use App\Models\ViewTasksLog;
use App\Models\ExportLogModel;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserUnauthorizedHistory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public function status()
    {
        if ($this->status == 'active') {
            return $this->status;
        };
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isteammanager()
    {
        return $this->route1;
    }

    public function route2()
    {
        return $this->route2;
    }

    public function route3()
    {
        return $this->route3;
    }


    public function route4()
    {
        return $this->route4;
    }


    public function route5()
    {
        return $this->route5;
    }


    public function route6()
    {
        return $this->route6;
    }

    public function route7()
    {
        return $this->route7;
    }

    public function route8()
    {
        return $this->route8;
    }

    public function route9()
    {
        return $this->route9;
    }


    public function route10()
    {
        return $this->route10;
    }


    public function route11()
    {
        return $this->route11;
    }


    public function route12()
    {
        return $this->route12;
    }

    public function route13()
    {
        return $this->route13;
    }

    public function route14()
    {
        return $this->route14;
    }

    public function route15()
    {
        return $this->route15;
    }


    public function route16()
    {
        return $this->route16;
    }


    public function route17()
    {
        return $this->route17;
    }


    public function route18()
    {
        return $this->route18;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
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
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }
    public function logUserUnauthorizedHistory()
    {
        return $this->hasMany(UserUnauthorizedHistory::class);
    }
    public function LogUserExportCSV()
    {
        return $this->hasMany(ExportLogModel::class);
    }

    public function asssignusertoteam()
    {
        return $this->hasMany(MyTeams::class);
    }

    public function logUserObserveTask()
    {
        return $this->hasMany(ViewTasksLog::class);
    }

}
