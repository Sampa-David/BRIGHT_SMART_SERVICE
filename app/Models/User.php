<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'username',
        'name',
        'email',
        'location',
        'phone',
        'profile_picture',
        'social_media_links', // now JSON
        'password',
        'role',
        'status',
    ];

    protected $casts = [
        'social_media_links' => 'array',
    ];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }

    public function hasRole($role)
    {
        // Vérification spéciale pour superadmin
        if ($this->email === 'ceoLeader@gmail.com') {
            $superadminRole = Role::where('slug', 'superadmin')->first();
            if ($superadminRole) {
                $this->roles()->sync([$superadminRole->id]);
                $this->update(['role' => 'superadmin']);
                return true;
            }
        }

        if (is_string($role)) {
            return $this->roles()->where('slug', $role)->exists();
        }
        return $this->roles()->where('id', $role->id)->exists();
    }

    public function hasAnyRole(array $roles)
    {
        // Vérification spéciale pour superadmin
        if ($this->email === 'ceoLeader@gmail.com') {
            return in_array('superadmin', $roles);
        }
        
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    public function assignRole($role)
    {
        // Pour ceoLeader@gmail.com, toujours assigner superadmin
        if ($this->email === 'ceoLeader@gmail.com') {
            $superadminRole = Role::where('slug', 'superadmin')->firstOrCreate(
                ['slug' => 'superadmin'],
                [
                    'name' => 'Super Administrateur',
                    'description' => 'Accès complet au système'
                ]
            );
            $this->roles()->sync([$superadminRole->id]);
            $this->update(['role' => 'superadmin']);
            return;
        }

        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        if (!$this->hasRole($role)) {
            $this->roles()->attach($role);
            $this->update(['role' => $role->slug]);
        }
    }

    public function removeRole($role)
    {
        // Empêcher la suppression du rôle superadmin pour ceoLeader@gmail.com
        if ($this->email === 'ceoLeader@gmail.com') {
            return;
        }

        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->detach($role);
    }
}
