<?php

return [
    'resources' => [
        'no_results' => 'No results found for the resource' . ': ' . ':resource.',
    ],
    'crud' => [
        'success' => [
            'title' => 'Congrats!',
            'text'  => 'The resource has been successfully :action.'
        ],
        'fail' => [
            'title' => 'Error detected..',
            'text'  => [
                'An error occurred during the :action process, and the operation can not be carried out successfully.',
                'If the error persists, please contact the system administrator: :email',
            ],
        ],
    ],
];
