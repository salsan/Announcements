<?php

declare(strict_types=1);

namespace Salsan\Announcements;

class News extends Nitobicom
{
  function __construct(int $items)
  {

    $type = "news";

    parent::setUrl($type, $items);

    $table = $this->getDOM(null);

    parent::setData($table);
  }

  function getData(): array
  {
    return parent::getData();
  }
}
