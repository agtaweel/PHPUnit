<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name','size'];

    public function add($user)
    {
        $this->guardAgainstTooManyMembers($user);
        $method = $user instanceof User ? 'save' :'saveMany';
        $this->members()->$method($user);
    }

    public function maxSize()
    {
        return $this->size;
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }
    protected function guardAgainstTooManyMembers($user)
    {
        if($this->extractNewUsersCount($user) > $this->maxSize())
        {
            throw new \Exception();
        }
    }

    public function remove($user)
    {
        if($user instanceof User)
            return $user->leaveTeam();
        return $this->removeMany($user);
    }
    public function restart()
    {
        return $this->members()->update(['team_id'=>null]);
    }

    public function removeMany($users)
    {

        return $this->members()
            ->whereIn('id',$users->pluck('id'))
            ->update(['team_id'=>null]);
    }

    public function extractNewUsersCount($users)
    {
        $numOfNewUsers = $users instanceof User ? 1:count($users);
        return $this->count() + $numOfNewUsers;
    }

}
