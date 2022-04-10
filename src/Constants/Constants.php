<?php

namespace Adminro\Constants;

class Constants
{
    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_UNDER_REVIEW = 2;
    const STATUS_ABANDONED = 3;
    const STATUS_PENDING = 4;
    const STATUS_DELETED = 5;

    const STATUS_PUBLISH = [
        [
            "title" => "Unpublished",
            "value" => Constants::STATUS_UNPUBLISHED,
        ],
        [
            "title" => "Published",
            "value" => Constants::STATUS_PUBLISHED,
        ],
        [
            "title" => "Under Review",
            "value" => Constants::STATUS_UNDER_REVIEW,
        ],
        [
            "title" => "Abandoned",
            "value" => Constants::STATUS_ABANDONED,
        ],
        [
            "title" => "Pending",
            "value" => Constants::STATUS_PENDING,
        ],
    ];

    const STATUS_PUBLISH_WITH_DELETED = [
        [
            "title" => "Unpublished",
            "value" => Constants::STATUS_UNPUBLISHED,
        ],
        [
            "title" => "Published",
            "value" => Constants::STATUS_PUBLISHED,
        ],
        [
            "title" => "Under Review",
            "value" => Constants::STATUS_UNDER_REVIEW,
        ],
        [
            "title" => "Abandoned",
            "value" => Constants::STATUS_ABANDONED,
        ],
        [
            "title" => "Pending",
            "value" => Constants::STATUS_PENDING,
        ],
        [
            "title" => "Deleted",
            "value" => Constants::STATUS_DELETED,
        ],
    ];

    const BULK_ACTION_VALUES = [
        'bulk_delete', 'bulk_restore', 'bulk_force_delete'
    ];
}
