<?php

declare(strict_types=1);

return [
    'crud' => [
        'success' => [
            'title' => 'Congrats!',
            'text' => 'The resource has been successfully :action.',
        ],
        'fail' => [
            'title' => 'Error detected..',
            'text' => [
                'An error occurred during the :action process, and the operation can not be carried out successfully.',
                'If the error persists, please contact the system administrator: :email',
            ],
        ],
    ],
    'delete' => [
        'item' => [
            'title' => 'Delete item',
            'confirm' => 'Are you sure you want to delete the selected item?',
        ],
        'selected' => [
            'title' => 'Delete selection',
            'confirm' => 'Are you sure you want to delete all the selected fields?',
        ],
    ],
    'fields' => [
        'empty' => 'The fields: :value, cannot be empty',
    ],
    'options' => [
        'success' => 'Your setting configuration has been stored!',
        'fail' => [
            'class' => 'The Class :value does not exist',
        ],
    ],
    'relationships' => [
        'new_field' => 'Notice!!! This will create a new row in the database: :value',
    ],
    'resources' => [
        'no_results' => 'No results found for the resource: :resource.',
    ],
];
