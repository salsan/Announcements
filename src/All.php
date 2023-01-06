<?php

declare(strict_types=1);

namespace Salsan\Announcements;

class All extends Nitobicom
{
  function __construct(int $items)
  {

    $type = "all";

    parent::setUrl($type, $items);

    $table = $this->getDOM(null);

    parent::setData($table);
  }
}
