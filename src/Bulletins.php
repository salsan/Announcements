<?php

declare(strict_types=1);

namespace Salsan\Announcements;

class Bulletins extends Nitobicom
{
  function __construct(int $items)
  {

    $type = "bulletins";

    parent::setUrl($type, $items);

    $table = $this->getDOM(null);

    parent::setData($table);
  }
}
