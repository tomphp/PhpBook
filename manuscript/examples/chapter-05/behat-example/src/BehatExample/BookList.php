<?php

namespace BehatExample;

class BookList
{
    /** @var array */
    private $books = [];

    public function clear()
    {
        $this->books = [];
    }

    /**
     * @param string $title
     * @param string $author
     */
    public function add($title, $author)
    {
        $this->books[] = [
            'title'  => $title,
            'author' => $author
        ];
    }

    /** @return array */
    public function getBooks()
    {
        $list = $this->books;

        usort($list, function ($a, $b) {
            return $a['title'] > $b['title'];
        });

        return $list;
    }
}
