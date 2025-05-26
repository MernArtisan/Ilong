<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DiscoverController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\GroupPostController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ProfessionalController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RolePermissionController;
use App\Http\Controllers\API\SocailController;
use App\Http\Controllers\API\UserRoleController;
use App\Models\Faq;
use App\Models\Permission;
use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
// ,'check.role.permission'
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('update-fcm-token', [DiscoverController::class, 'updateFcmToken']);
    Route::get('profile', [ProfileController::class, 'Authprofile']);
    Route::post('profile/update', [ProfileController::class, 'AuthUpdateProfile']);
    Route::post('professional-profile-update', [ProfileController::class, 'ProffessionalProfileUpdate']);
    Route::post('/update-profile-images/{user_id}', [ProfileController::class, 'ProfileImagesUpdate']);

    Route::post('/children-profile', [ProfileController::class, 'childrenProfile'])->name('children-profile');
    Route::post('posts-content', [PostController::class, 'postsContent']);
    Route::get('posts/latest', [PostController::class, 'getLatestPosts']);
    Route::get('post/{id}/all', [PostController::class, 'getPostsByUserId']);
    Route::post('follow/{userId}', [PostController::class, 'followUser']);
    Route::get('post/{postId}/comments', [PostController::class, 'getComments']);
    Route::post('share-post', [PostController::class, 'sharePost']);
    Route::post('share-group-post', [PostController::class, 'shareGroupPost']);

    Route::post('post/{postId}/like', [PostController::class, 'likePost']);
    Route::post('/post/{postId}/comment', [PostController::class, 'addComment']);

    Route::post('groups',  [GroupController::class, 'createGroup']);
    Route::get('/groups',  [GroupController::class, 'listGroups']);
    Route::post('/groups/{groupId}/join',  [GroupController::class, 'joinGroup']);

    Route::get('my-group', [GroupController::class, 'MyGroup']);
    Route::get('get-specific-group/{id}', [GroupController::class, 'getSpecificGroups']);
    Route::post('group-post', [GroupPostController::class, 'groupPost']);
    Route::get('/group-posts/{id}', [GroupPostController::class, 'getGroupPosts']);
    Route::get('/user-posts/{id}', [GroupPostController::class, 'getUserPosts']);

    Route::post('/group-posts/{postId}/like', [GroupPostController::class, 'likePost']);
    Route::post('/group-posts/{postId}/comment', [GroupPostController::class, 'addComment']);
    Route::get('group-posts/{postId}/comments', [GroupPostController::class, 'getPostcomments']);



    Route::get('faqs', [SocailController::class, 'faqs']);
    Route::get('privacy', [SocailController::class, 'privacy']);
    Route::post('change-password', [SocailController::class, 'changePassword']);
    Route::post('inquiries', [SocailController::class, 'inquiries']);
    Route::get('admin-detail', [SocailController::class, 'adminDetail']);
    Route::delete('delete-account', [SocailController::class, 'deleteAccount']);
    Route::get('get-professional', [DiscoverController::class, 'getProfessional']);
    Route::get('get-professional/{id}', [DiscoverController::class, 'getSpecificProfessional']);

    Route::post('post-availability', [ProfessionalController::class, 'postAvailability']);
    Route::get('get-available-slots/{id}', [DiscoverController::class, 'getAvailableSlots']);
    Route::post('book-slot', [DiscoverController::class, 'BookSlot']);


    Route::get('appointment-request-all', [ProfessionalController::class, 'appointmentRequestAll']);

    Route::post('accept-booking', [ProfessionalController::class, 'acceptBooking']);
    Route::post('cancel-booking', [ProfessionalController::class, 'cancelBooking']);
    Route::post('booking/complete', [DiscoverController::class, 'completeBooking']);
    Route::post('booking/dispute', [DiscoverController::class, 'disputeBooking']);

    // request accepted completed cancelled dispute Route will here
    Route::get('/appointments', [ProfessionalController::class, 'manageAppointment']);
    Route::get('specific-request/{id}', [ProfessionalController::class, 'specifiedRequest']);
    Route::get('count-request', [ProfessionalController::class, 'countRequest']);
    // Route::get('count-complete', [ProfessionalController::class, 'countComplete']);
    Route::post('upload-videos', [DiscoverController::class, 'uploadVideos']);
    Route::get('my-videos', [DiscoverController::class, 'MyVideos']);
    Route::delete('my-videos/{id}', [DiscoverController::class, 'deleteMyVideo']);
    Route::post('my-videos/{id}', [DiscoverController::class, 'editMyVideo']);

    Route::get('/get-videos-random-order', [DiscoverController::class, 'getVideos']);
    Route::post('videos/{videoId}/like', [DiscoverController::class, 'likeVideo']);
    Route::post('videos/{videoId}/comment', [DiscoverController::class, 'commentOnVideo']);
    Route::get('/videos/{videoId}/comments', [DiscoverController::class, 'getComments']);
    Route::get('user-search', [DiscoverController::class, 'search']);
    Route::get('pro-earning', [DiscoverController::class, 'earning']);

    Route::post('messages', [DiscoverController::class, 'messagePost']);
    Route::get('messages-get', [DiscoverController::class, 'getMessages']);

    Route::get('get-slots', [DiscoverController::class, 'getSlots']);
    Route::get('notification-get', [DiscoverController::class, 'getNotification']);
    Route::post('seen-notifications', [DiscoverController::class, 'seenNotification']);
    // likepost //
    // commenpost //
    // sharepost //
    // bookslot //
    // accept //
    // cancel //
    // dispute //
    // complete //
    // video like //
    // video commented //
    // group like //
    // group commented // 
    // group share 
    // group join 
































    Route::get('/get-posts', [PostController::class, 'posts'])->name('get-posts');
    // Roles and permissions routes
    Route::get('roles', [RoleController::class, 'index'])->name('roles');
    Route::post('roles-create', [RoleController::class, 'create'])->name('roles-create');
    Route::post('roles-update/{id}', [RoleController::class, 'update'])->name('roles-update');
    Route::delete('roles-delete/{id}', [RoleController::class, 'delete'])->name('roles-delete');

    Route::get('permission', [PermissionController::class, 'index'])->name('permission');
    Route::post('permission-create', [PermissionController::class, 'create'])->name('permission-create');
    Route::post('permission-update/{id}', [PermissionController::class, 'update'])->name('permission-update');
    Route::delete('permission-delete/{id}', [PermissionController::class, 'delete'])->name('permission-delete');

    // Assign Roles to User routes
    Route::post('user-roles/assign', [UserRoleController::class, 'assign'])->name('user-roles.assign');
    Route::delete('user-roles/remove', [UserRoleController::class, 'remove'])->name('user-roles.remove');

    // Assign Permissions to Roles
    Route::post('role-permissions/assign', [RolePermissionController::class, 'assign'])->name('role-permissions.assign');
    Route::post('role-permissions/remove', [RolePermissionController::class, 'remove'])->name('role-permissions.remove');
});
