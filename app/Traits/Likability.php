<?php


namespace App\Traits;


use App\Models\Like;
use Illuminate\Support\Facades\Auth;

trait Likability
{
    public function like()
    {
        $like = new Like(['user_id'=>Auth::id()]);
        $this->likes()->save($like);
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likable');
    }

    public function isLiked()
    {
        return !! $this->likes()
            ->where('user_id', Auth::id())
            ->count();
    }


    public function unlike()
    {
        return $this->likes()
            ->where('user_id',Auth::id())->delete();
    }

    public function toggleLike()
    {
        if($this->isLiked())
        {
            return $this->unlike();
        }
        return $this->like();
    }

    public function getLikesAttributeCount()
    {
        return $this->likes()->count();
    }
}
