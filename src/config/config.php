<?php
return [
    'filters' => [

        // These filters are used for the collection that has one data.
        'small-collection' => [
            'with',
            'withTrashed'
        ],

        // These filters are used for the collections that are not too big and less than 100 data
        'medium-collection' => [
            'with',
            'orderBy',
            'withTrashed'
        ],

        // These filters are used for the collections that are too big and more than 100 data
        'big-collection' => [
            'with',
            'orderBy',
            'withTrashed',
            'paginate'
        ],

        // Storage of the filters class
        'path' => 'App\\Repositories\\Filters'
    ]
];
