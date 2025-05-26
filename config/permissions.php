<?php
return [
    'routes' => [
        'profile-update' => 'update-profile',
        'get-posts' => 'view_posts',
        'roles' => 'manage-roles',
        'roles-create' => 'create-roles',
        'roles-update' => 'edit-roles',
        'roles-delete' => 'delete-roles',
        'permission' => 'view-permissions',
        'permission-create' => 'create-permissions',
        'permission-update' => 'edit-permissions',
        'permission-delete' => 'delete-permissions',
        'user-roles/assign' => 'assign-roles',
        'user-roles/remove' => 'remove-roles',
        'role-permissions/assign' => 'assign-permissions',
        'role-permissions/remove' => 'remove-permissions',
    ],
];
