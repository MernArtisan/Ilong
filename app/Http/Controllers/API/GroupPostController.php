<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\ContentPostComment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GroupPostController extends Controller
{

    public function groupPost(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'description' => 'nullable|string',
            'group_id' => 'required|exists:groups,id', // Group must exist
            'image' => 'nullable|array',             // Multiple images allowed
            'image.*' => 'file|mimes:jpeg,png,jpg,gif|max:2048', // Validate each file
            'hide' => 'nullable',
        ]);

        $imagePaths = [];

        // Check if images are uploaded
        if ($request->has('image')) {
            foreach ($request->file('image') as $image) {
                $directory = public_path('GroupPosts');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                $fileName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move($directory, $fileName);
                $imagePaths[] = $fileName;
            }
        }

        // Create a new GroupPost
        $post = GroupPost::create([
            'description' => $validated['description'],
            'group_id' => $validated['group_id'],
            'user_id' => auth()->id(),
            'image' => json_encode($imagePaths),
            'hide' => $validated['hide'],
        ]);

        return response()->json(['post' => $post], 201);
    }

    public function getGroupPosts($id)
    {
        $userId = auth()->id();

        $posts = GroupPost::where('group_id', $id)
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'role', 'image');
            }])
            ->with('likes')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'description', 'image', 'user_id', 'hide','share','share_person','share_count']);

        $posts = $posts->map(function ($post) use ($userId) {
            $isLiked = $post->likes->contains('user_id', $userId);
            return [
                'id' => $post->id,
                'description' => $post->description,
                'images' => $post->image ? array_map(function ($path) {
                    return asset('GroupPosts/' . $path); 
                }, json_decode($post->image)) : [],
                'user_id' => $post->user->id,
                'image' => asset('profile_image/' . $post->user->image),
                'first_name' => $post->user->first_name,
                'role' => $post->user->role,
                'likes' => $post->likes->count(),
                'comments' => $post->comments->count(),
                'shares' => $post->share_count,
                'share' => $post->share,
                'is_like' => $isLiked,
                'hide' => strval($post->hide),
                'share_person' => $post->share_person,
            ];
        });

        return response()->json(['posts' => $posts]);
    }

    public function getUserPosts($id)
    {
        $currentUser = auth()->user();

        $posts = Post::where('user_id', $id)
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'first_name', 'role');
                },
                'likes',
                'images',
                'comments'
            ])
            ->orderBy('created_at', 'desc')
            ->get(['id', 'description', 'name', 'content', 'user_id', 'share_count','share_person','share']);

        $posts = $posts->map(function ($post) use ($currentUser) {

            $isLike = $post->likes->where('user_id', $currentUser->id)->isNotEmpty();
            
            return [
                'id' => $post->id,
                'description' => $post->description,
                'name' => $post->name,
                'content' => $post->content,
                'images' => $post->images->map(function ($image) {
                    return asset('contentpost/' . $image->image_path);
                }),
                'user_id' => $post->user->id,
                'first_name' => $post->user->first_name,
                'role' => $post->user->role,
                'is_like' => $isLike,
                'share' => $post->share,
                'share_person' => $post->share_person,
                'likes' => $post->likes->count(),
                'comments' => $post->comments->count(),
                'shares' => $post->share_count,
            ];
        });

        return response()->json(['posts' => $posts]);
    }





    public function likePost($postId)
    {
        $userId = auth()->id();

        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();
        $groupPost = GroupPost::find($postId);
        if (!$groupPost) {
            return response()->json(['message' => 'Group post not found'], 404);
        }
        $postOwner = $groupPost->user;
        $fcmToken = $postOwner->fcm_token;
        $UserId = $postOwner->id;
        // dd($postOwner);
        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like removed']);
        } else {
            Like::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            $authUser = auth()->user();

            Notification::create([
                'user_id' => $UserId,
                'message' => $authUser->first_name . ' has Like your Group Post.',
                'notifyBy' => 'Like Group Post',
            ]);
            return response()->json([
                'message' => 'Post liked',
                'fcm_token' => $fcmToken,
            ]);
        }
    }


    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        $groupPost = GroupPost::find($postId);
        if (!$groupPost) {
            return response()->json(['message' => 'Group post not found'], 404);
        }
        $postOwner = $groupPost->user;
        $fcmToken = $postOwner->fcm_token;
        $UserId = $postOwner->id;
        Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
        $authUser = auth()->user();

        Notification::create([
            'user_id' => $UserId,
            'message' => $authUser->first_name . ' has Commented your Group Post.',
            'notifyBy' => 'Commented Group Post',
        ]);
        return response()->json([
            'comment' => $request->comment,
            'fcm_token' => $fcmToken,
            'message' => 'Comment added successfully'
        ]);
    }

    public function getPostcomments($postId)
    {
        $comments = Comment::where('post_id', $postId)
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'role', 'image');
            }])
            ->get(['id', 'comment', 'user_id']);
        // return $comments;
        $comments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user_id' => $comment->user->id,
                'first_name' => $comment->user->first_name,
                'image' => $comment->user->image
                    ? asset('profile_image/' . $comment->user->image)
                    : asset('default.png'),
            ];
        });

        return response()->json([
            'comment' => $comments
        ]);
    }
}
