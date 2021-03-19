<?php

namespace App\Traits;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait UserTrait {
    public function save(array $options = []){
        $user = Auth::user();
        if($user) {
            $this->user_id = $user->id;
        }
        parent::save($options);
    }
}