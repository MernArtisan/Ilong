<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function createGroup(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ]);

            $creator = Auth::user(); 
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('group_images'), $imageName);
                $imagePath = $imageName;
            }

            $group = Group::create([
                'name' => $request->name,
                'description' => $request->description,
                'creator_id' => $creator->id,
                'image' => $imagePath,
            ]);


            // Return success response
            return response()->json(['message' => 'Group created successfully', 'group' => $group], 201);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }


    public function listGroups()
    {
        $user = auth()->user();

        $groups = Group::with('creator:id,role')
            ->get(['id', 'name', 'image', 'creator_id']);

        $groups->each(function ($group) use ($user) {
            // Check if the user is already a member of the group
            $alreadyJoined = $group->users()->where('user_id', $user->id)->exists();

            // If the user is the creator of the group, set 'joined' to true
            if ($group->creator_id == $user->id) {
                $alreadyJoined = true;
            }

            // Get the role of the creator, if it exists
            $creatorRole = $group->creator ? $group->creator->role : null;

            // Set group properties
            $group->image = $group->image ? asset('group_images/' . $group->image) : null;
            $group->joined = $alreadyJoined;  // Set 'joined' to true if the user is in the group or is the creator
            $group->role = $creatorRole;  // Role of the creator
        });

        return response()->json(['groups' => $groups]);
    }

    public function joinGroup(Request $request, $groupId)
    {
        try {
            $user = Auth::user();
            $group = Group::find($groupId);

            if (!$group) {
                return response()->json(['message' => 'Group not found'], 404);
            }

            if ($group->creator_id  == $user->id) {
                return response()->json(['message' => 'You cannot join your own group'], 403);
            }

            if ($group->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['message' => 'You are already a member of this group'], 409);
            }

            $group->users()->attach($user->id);
            $creator = User::find($group->creator_id);
            if ($creator && $creator->fcm_token) {
                $fcmToken = $creator->fcm_token;
                $UserId = $creator->id;
            } else {
                $fcmToken = null;
            }

            $authUser = auth()->user();

            Notification::create([
                'user_id' => $UserId,
                'message' => $authUser->first_name . ' has Joined your Group.',
                'notifyBy' => 'Group Joined',
            ]);
            return response()->json([
                'status' => true,
                'fcm_token' => $fcmToken,
                'message' => 'User joined the group successfully'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getSpecificGroups($id)
    {
        $user = auth()->user();

        // Find the group by ID and select necessary fields
        $group = Group::select('id', 'name', 'description', 'image', 'created_at', 'creator_id')->find($id);

        if ($group) {
            // Format the created_at date
            $group->create = $group->created_at ? $group->created_at->format('d M Y') : null;

            // Count members in the group
            $memberCount = DB::table('group_user')
                ->where('group_id', $id)
                ->count();
            $group->member_count = $memberCount;

            // Set group image URL
            $group->image = $group->image ? asset('group_images/' . $group->image) : null;

            // Check if the current user is the group creator or has joined the group
            $isCreator = $group->creator_id === $user->id;
            $hasJoined = DB::table('group_user')
                ->where('group_id', $id)
                ->where('user_id', $user->id)
                ->exists();

            // Add join status to the group object
            $group->joined = $isCreator || $hasJoined; // true if user is the creator or has joined the group

            // Return the group data with the join status
            return response()->json(['group' => $group]);
        }

        // Return 404 if the group is not found
        return response()->json(['message' => 'Group not found'], 404);
    }




    public function MyGroup()
    {
        $user = Auth::user();

        // Fetch the groups the user has joined
        $joinedGroups = $user->groups()->get();

        // Fetch the groups the user has created (assuming 'creator_id' field is used to track creators)
        $createdGroups = $user->createdGroups; // Assuming you have a relationship named 'createdGroups' defined in User model

        // Map to include image URLs and format the created_at date
        $joinedGroups = $joinedGroups->map(function ($group) {
            $group->image = asset('group_images/' . $group->image);
            $group->created_at = Carbon::parse($group->created_at)->format('d M Y'); // Format created_at date
            return $group;
        });

        $createdGroups = $createdGroups->map(function ($group) {
            $group->image = asset('group_images/' . $group->image);
            $group->created_at = Carbon::parse($group->created_at)->format('d M Y'); // Format created_at date
            return $group;
        });

        // Return both sets of groups
        return response()->json([
            'joined_groups' => $joinedGroups,
            'created_groups' => $createdGroups,
        ]);
    }
}
