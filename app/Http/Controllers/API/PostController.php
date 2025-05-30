<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContentPostComment;
use App\Models\ContentPostLike;
use App\Models\Follow;
use App\Models\Group;
use App\Models\GroupPost;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function postsContent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'images.*' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'hide' => 'nullable'
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'] ?? null, // Provide a fallback to null if 'name' is not present
            'description' => $validated['description'] ?? null,
            'content' => $validated['content'] ?? null,
            'share' => 0,
            'hide' => $validated['hide'],
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('contentpost'), $imageName);
                Image::create([
                    'post_id' => $post->id,
                    'image_path' => $imageName,
                ]);
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Post with images created successfully!',
        ]);
    }

    public function getLatestPosts()
    {
        $currentUser = auth()->user();

        $posts = Post::with(['user:id,first_name,role,image', 'images', 'likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();

        $formattedUsers = $posts->map(function ($post) use ($currentUser) {
            $user = $post->user;

            $isLike = $post->likes()->where('user_id', $currentUser->id)->exists();

            return [
                'id' => $post->id,
                'user_id' => $user->id,
                'image' => $user->image ? asset('profile_image/' . $user->image) : asset('default.png'),
                'first_name' => $user->first_name,
                'role' => $user->role,
                'content' => $post->content,
                'share' => $post->share,
                'share_person' => $post->share_person,
                'images' => $post->images->map(function ($image) {
                    return asset('contentpost/' . $image->image_path);
                })->toArray(),
                'likes' => $post->likes->count(),
                'comments' => $post->comments->count(),
                'shares' => $post->share_count,
                'is_like' => $isLike,
                'hide' => strVal($post->hide)
            ];
        });

        return response()->json([
            'status' => 200,
            'users' => $formattedUsers,
            'message' => 'Users with their latest post content and images fetched successfully!',
        ]);
    }




    public function getPostsByUserId($userId)
    {
        // Authenticated user (assuming you're using Laravel Auth)
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated!',
                'posts' => []
            ]);
        }
 
        $user = User::with(['posts.images', 'posts.likes', 'posts.comments'])
            ->where('id', $userId)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found!',
                'posts' => []
            ]);
        }
        $followers = Follow::where('follower_id', $userId)->count();

        $isFollow = $currentUser->following()->where('following_id', $userId)->exists();


        $posts = $user->posts->map(function ($post) use ($user, $currentUser) {
            $isLike = $post->likes()->where('user_id', $currentUser->id)->exists();


            if ($post->share == 1) {

                $originalPost = Post::find($post->post_id);
                $shareCount = $originalPost ? $originalPost->share : 0;
            } else {

                $shareCount = $post->share;
            }

            return [
                'id' => $post->id,
                'image' => asset('profile_image/' . $user->image),
                'user_name' => $user->first_name,
                'user_role' => $user->role,
                'content' => $post->content,
                'images' => $post->images->map(function ($image) {
                    return asset('contentpost/' . $image->image_path);
                }),
                'share' => $post->share,
                'share_person' => $post->share_person,
                'likes_count' => $post->likes->count(),
                'comments_count' => $post->comments->count(),
                'share_count' => $shareCount,
                'is_like' => $isLike,
            ];
        });

        // Final response return
        return response()->json([
            'status' => 200,
            'cover_image' => $user->cover_image ? asset('profile_image/' . $user->cover_image) : asset('default.png'),
            'image' => $user->image ? asset('profile_image/' . $user->image) : asset('default.png'),
            'user_name' => $user->first_name,
            'user_role' => $user->role,
            'is_follow' => $isFollow, // Whether current user follows this user
            'followers' => $followers,
            'posts' => $posts,
            'message' => 'User posts fetched successfully!',
        ]);
    }



    public function likePost(Request $request, $postId)
    {
        $userId = auth()->id();  
        $like = ContentPostLike::where('post_id', $postId)->where('user_id', $userId)->first();
        $postOwner = Post::where('id', $postId)->with('user')->first();  // Load user relationship too

        if (!$postOwner) {
            return response()->json(['status' => false, 'message' => 'Post not found.']);
        }

        $fcmToken = $postOwner->user->fcm_token ?? null;

        if ($like) {
            // Already liked, so unlike it
            $like->delete();
            return response()->json(['status' => true, 'message' => 'Post unliked successfully.']);
        } else {
            // Like the post
            $authUser = auth()->user();

            Notification::create([
                'user_id'     => $postOwner->user->id,
                'message'     => $authUser->first_name . ' has liked your post.',
                'notifyBy'    => 'Post Like',
                'action_type' => 'likePost',
                'action_id'   => $postId,
            ]);

            ContentPostLike::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);

            return response()->json([
                'status'     => true,
                'message'    => 'Post liked successfully.',
                'fcm_token'  => $fcmToken,
            ]);
        }
    }




    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $postOwner = Post::where('id', $postId)->with('user')->first();

        if (!$postOwner) {
            return response()->json(['status' => false, 'message' => 'Post not found.']);
        }

        $fcmToken = $postOwner->user->fcm_token ?? null;

        if (!$fcmToken) {
            return response()->json(['status' => false, 'message' => 'FCM token not found for the post owner.']);
        }

        $authUser = auth()->user();

        Notification::create([
            'user_id' => $postOwner->user->id,
            'message' => $authUser->first_name . ' has commented on your post: ' . $request->comment,
            'notifyBy' => 'Post Comment',
            'action_type' => 'commentPost',
            'action_id' => $postId,
        ]);

        $comment = ContentPostComment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'comment' => $request->comment,
            'fcm_token' => $fcmToken ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment added successfully.',
            'fcm_token' => $fcmToken,
        ]);
    }



    public function followUser(Request $request, $followingId)
    {
        $user = auth()->user(); // Authenticated user
        $followingUser = User::find($followingId); // User to be followed

        if (!$followingUser) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Check if already following
        if ($user->following()->where('following_id', $followingId)->exists()) {
            // Unfollow the user
            $user->following()->detach($followingId);
            return response()->json([
                'status' => true,
                'message' => 'Unfollowed successfully.',
            ], 200);
        }

        // Follow the user
        $user->following()->attach($followingId);

        return response()->json([
            'status' => true,
            'message' => 'Followed successfully.',
        ], 200);
    }


    public function getComments($postId)
    {
        $post = ContentPostComment::where('post_id', $postId)
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'role', 'image');
            }])
            ->get(['id', 'comment', 'user_id']);
        $post = $post->map(function ($post) {
            return [
                'id' => $post->id,
                'comment' => $post->comment,
                'user_id' => $post->user->id,
                'first_name' => $post->user->first_name,
                'image' => $post->user->image
                            ? asset('profile_image/' . $post->user->image)
                            : asset('default.png'),
                // 'role'=> $comments->user->role,
                // 'likes'=> $comments->likes->count(),
                // 'shares'=> rand(1, 20),
            ];
        });
        return response()->json([
            'comment' => $post
        ]);
    }



    public function sharePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
            'share_to' => 'required|string',
            'group_id' => 'nullable|integer',
        ]);

        $user = auth()->user();
        $post = Post::find($request->post_id);

        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Post not found.']);
        }

        $originalPoster = $post->user;

        if (!$originalPoster) {
            return response()->json(['status' => false, 'message' => 'Original poster not found.']);
        }

        $post->increment('share_count');

        if ($request->share_to == 'profile') {
            $newPost = Post::create([
                'user_id' => $user->id,
                'content' => $post->content,
                'name' => $post->name,
                'description' => $post->description,
                'share' => 1,
                'share_person' => $originalPoster->first_name . ' ' . $originalPoster->last_name,
                'hide' => 1,
            ]);

            foreach ($post->images as $image) {
                Image::create([
                    'post_id' => $newPost->id,
                    'image_path' => $image->image_path,
                ]);
            }

            $authUser = auth()->user();

            Notification::create([
                'user_id' => $originalPoster->id,
                'message' => $authUser->first_name . ' has shared your post.',
                'notifyBy' => 'Post Share To Profile',
                'action_type' => 'sharePostToProfile',
                'action_id' => $newPost->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Post shared to profile successfully.',
                'fcm_token' => $originalPoster->fcm_token
            ]);
        }

        if ($request->share_to == 'group') {
            $group = Group::where('id', $request->group_id)->first();

            $isMember = \DB::table('group_user')
                ->where('group_id', $group->id)
                ->where('user_id', $user->id)
                ->exists();

            if (!$group || !$isMember) {
                return response()->json([
                    'status' => false,
                    'message' => 'Group not found or you do not have permission.'
                ]);
            }


            // Move images
            $imagePaths = [];
            foreach ($post->images as $image) {
                $originalPath = public_path('contentpost/' . $image->image_path);
                $newPath = public_path('GroupPosts/' . $image->image_path);

                if (!File::exists(public_path('GroupPosts'))) {
                    File::makeDirectory(public_path('GroupPosts'), 0777, true);
                }

                if (File::exists($originalPath)) {
                    File::copy($originalPath, $newPath);
                }

                $imagePaths[] = $image->image_path;
            }

            $groupPost = GroupPost::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'description' => $post->content,
                'image' => json_encode($imagePaths),
                'share' => 1,
                'share_person' => $originalPoster->first_name . ' ' . $originalPoster->last_name,
                'hide' => 1,
            ]);

            // Send notification to original poster
            Notification::create([
                'user_id' => $originalPoster->id,
                'message' => $user->first_name . ' has shared your post to a group.',
                'notifyBy' => 'Post Share To Group',
                'action_type' => 'sharePostToGroup',
                'action_id' => $groupPost->id,
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Post shared to group successfully.',
                'fcm_token' => $originalPoster->fcm_token
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid share option.']);
    }



    public function shareGroupPost(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
            'share_to' => 'required|string',
            'group_id' => 'nullable|integer',
        ]);

        $user = auth()->user();
        $post = GroupPost::find($request->post_id);

        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Post not found.']);
        }

        $originalPoster = $post->user;

        if (!$originalPoster) {
            return response()->json(['status' => false, 'message' => 'Original poster not found.']);
        }

        $post->increment('share_count');
        $sharedToProfile = false;
        $sharedToGroup = false;

        // ✅ Profile Sharing
        if ($request->share_to == 'profile' || $request->share_to == 'both') {
            $newPost = Post::create([
                'user_id' => $user->id,
                'content' => $post->description,
                'name' => $post->name,
                'description' => $post->description,
                'share' => 1,
                'share_person' => $originalPoster->first_name . ' ' . $originalPoster->last_name,
                'hide' => 1,
            ]);

            foreach (json_decode($post->image) as $image) {
                $originalPath = public_path('GroupPosts/' . $image);
                $newPath = public_path('contentpost/' . $image);

                if (!File::exists(public_path('contentpost'))) {
                    File::makeDirectory(public_path('contentpost'), 0777, true);
                }

                if (File::exists($originalPath)) {
                    File::copy($originalPath, $newPath);
                }

                Image::create([
                    'post_id' => $newPost->id,
                    'image_path' => $image,
                ]);
            }

            Notification::create([
                'user_id' => $originalPoster->id,
                'message' => $user->first_name . ' has shared your group post to their profile.',
                'notifyBy' => 'Group Post Share to Profile',
                'action_type' => 'sharedGroupPostToProfile',
                'action_id' => $newPost->id,
            ]);

            $sharedToProfile = true;
        }

        // ✅ Group Sharing
        if ($request->share_to == 'group' || $request->share_to == 'both') {
            $group = Group::find($request->group_id);

            // 👇 Member check
            $isMember = \DB::table('group_user')
                ->where('group_id', $group->id)
                ->where('user_id', $user->id)
                ->exists();

            if (!$group || !$isMember) {
                return response()->json(['status' => false, 'message' => 'Group not found or you do not have permission.']);
            }

            $imagePaths = [];
            foreach (json_decode($post->image) as $image) {
                $originalPath = public_path('GroupPosts/' . $image);
                $newPath = public_path('GroupPosts/' . $image);

                if (!File::exists(public_path('GroupPosts'))) {
                    File::makeDirectory(public_path('GroupPosts'), 0777, true);
                }

                if (File::exists($originalPath)) {
                    File::copy($originalPath, $newPath);
                }

                $imagePaths[] = $image;
            }

            GroupPost::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'description' => $post->description,
                'image' => json_encode($imagePaths),
                'share' => 1,
                'share_person' => $originalPoster->first_name . ' ' . $originalPoster->last_name,
                'hide' => 1,
            ]);

            // 🔔 Optional: Notify the original post owner if you want
            Notification::create([
                'user_id' => $originalPoster->id,
                'message' => $user->first_name . ' has shared your group post to another group.',
                'notifyBy' => 'Group Post Share to Group',
                'action_type' => 'sharedGroupPostToGroup',
                'action_id' => $post->id,
            ]);

            $sharedToGroup = true;
        }

        $message = 'Post shared successfully.';
        if ($sharedToProfile && !$sharedToGroup) {
            $message = 'Post shared to profile successfully.';
        } elseif ($sharedToGroup && !$sharedToProfile) {
            $message = 'Post shared to group successfully.';
        } elseif ($sharedToProfile && $sharedToGroup) {
            $message = 'Post shared to both profile and group successfully.';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'fcm_token' => $originalPoster->fcm_token
        ]);
    }
}
