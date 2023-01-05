<?php

declare(strict_types=1);

namespace Salsan\Announcements;

use DOMDocument;

class Nitobicom
{
  private string $url;
  private DOMDocument $dom;
  private array $news;
  private int $items;

  function __construct(string $type, ?int $items = null)
  {
    $this->items = $items;

    $this->setUrl($type, $this->items);
    $table = $this->getDOM(null);
    $this->setData($table);
  }

  protected function getDOM(?string $url): DOMDocument
  {
    $this->dom = new DOMDocument();
    libxml_use_internal_errors(true);

    $url = $url ?? $this->url;

    $html = file_get_contents($url);
    $this->dom->loadHTML('<!DOCTYPE html><meta charset="UTF-8">' . $html); // workaround for issue #2 https://stackoverflow.com/a/8218649/1501286

    $this->dom->getElementsByTagName("table")->item(0);
    $this->setData($this->dom);

    return $this->dom;
  }

  public function setData(DOMDocument $data): void
  {
    $this->news = [];

    $row = $data->getElementsByTagName("tr");

    $index = 0;
    $is_odd = 0;

    foreach ($row as $article) {
      if ($article->childElementCount === 2) {
        if ($is_odd == 0) {
          $this->news[$index]["date"] = str_replace(
            "[",
            "",
            $article->getElementsByTagName("em")[0]->textContent,
          );
          $this->news[$index]["title"] = $article->getElementsByTagName(
            "strong",
          )[0]->textContent;

          $this->news[$index]["link"] =
            $article?->getElementsByTagName("a")[0]?->getAttribute("href") ??
            "";
          $is_odd = 1;
        } else {
          $this->news[$index]["content"] = $article->getElementsByTagName(
            "div",
          )[0]->textContent;

          $this->news[$index]["image"] =
            $article?->getElementsByTagName("img")[0]?->getAttribute("src") ??
            "";

          $index++;
          $is_odd = 0;
        }
      }
    }
  }

  protected function setUrl(string $type, ?int $items = null): void
  {
    $nitobi = ["bulletins" => 1, "news" => 2, "all" => 3];
    $this->items = $items ?? $this->items;

    $this->url =
      "http://www.federscacchi.it/nitobi_com.php?tipo=" .
      $nitobi[$type] .
      "&quanti=" .
      $this->items;
  }

  public function getData(): array
  {
    return $this->news;
  }

  public function setItems(int $items):void
  {
    $this->items = $items;
  }
}
