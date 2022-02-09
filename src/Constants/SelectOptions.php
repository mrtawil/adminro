<?php

namespace Adminro\Constants;

class SelectOptions
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
}
