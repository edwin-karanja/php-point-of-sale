<?php
/**
 * Settings specific to the POS are stored here
 */
return [
    /**
     * Contains an array of the emails for the system administrators.
     */
    'admins' => [
        'eddzzy@gmail.com'
    ],

    'modules' => [
        'products' => true,
        'inventory' => true,
        'customers' => false,
        'purchases' => true,
        'sales' => false,
        'reports' => false,
        'settings' => [
            'security' => true,
            'profile' => true,
            'user' => true,
            'store' => true,
            'roles_permissions' => false
        ]
    ]

];