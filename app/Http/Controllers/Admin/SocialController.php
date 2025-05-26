<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        $users = User::with(['posts', 'groups', 'createdGroups'])
            ->where('id', '!=', Auth::id())
            ->where(function ($query) {
                $query->whereHas('posts')
                    ->orWhereHas('groups')
                    ->orWhereHas('createdGroups');
            })
            ->get();

        return view('admin.social.index', compact('users'));
    }

    public function show($id)
    {
        $authId = Auth::id();
    
        $user = User::with([
                'posts' => function($query) {
                    $query->with(['images', 'comments', 'likes']);
                },
                'groups',          
                'createdGroups'   
            ])
            ->where('id', $id)
            ->where('id', '!=', $authId) 
            ->where(function ($query) {
                $query->whereHas('posts')         
                      ->orWhereHas('groups')       
                      ->orWhereHas('createdGroups'); 
            })
            ->firstOrFail(); 
        return view('admin.social.show', compact('user'));
    }
    
    
}
