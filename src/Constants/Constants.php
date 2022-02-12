<?php

namespace Adminro\Constants;

class Constants
{
    const PUBLISH = [
        [
            "title" => "Unpublished",
            "value" => 0,
        ],
        [
            "title" => "Published",
            "value" => 1,
        ],
        [
            "title" => "Under Review",
            "value" => 2,
        ],
        [
            "title" => "Abandoned",
            "value" => 3,
        ],
    ];

    const PUBLISH_WITH_DELETED = [
        [
            "title" => "Unpublished",
            "value" => 0,
        ],
        [
            "title" => "Published",
            "value" => 1,
        ],
        [
            "title" => "Under Review",
            "value" => 2,
        ],
        [
            "title" => "Abandoned",
            "value" => 3,
        ],
        [
            "title" => "Deleted",
            "value" => 4,
        ],
    ];

    const BULK_ACTION_VALUES = [
        'bulk_delete', 'bulk_restore',  'bulk_force_delete'
    ];
}
