<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super-admin' => [
            'users' => 'c,r,u,d,s',
            'roles' => 'c,r,u,d,s',  // Roles && assign permission
            'managers' => 'c,r,u,d,s',
            'profile' => 'r,u,s',
        ],
        'admin' => [
            'users' => 'r',
            'profile' => 'r,u,s',
        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'show',
    ],
];
