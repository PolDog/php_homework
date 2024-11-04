<?php
echo("HW04");
// =====  ex01-5  ========

interface IBook
{
    function getBook(int $id): string;
    function rememberPage(): int;
}

abstract class Book implements IBook
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected int $amountPages;
    protected int $currentPage;
    protected string $storagePlace;
    protected int $amountReaders;

    function __construct(string $name, float $price, int $amountPages) {}

    function openBook() {}
    function closeBook() {}
    function openBookOnPage(int $pageNumber) {}
    function rememberPage(): int
    {
        return $this->currentPage;
    }

    function getBook(int $id): string
    {
        return $this->storagePlace;
    }
}

class DigitalBook extends Book
{
    protected string $bookLink;

    function getBook(int $id): string
    {
        return $this->bookLink;
    }
}

class RealBook
{
    protected string $libraryAdress;

    function getBook(int $id): string
    {
        return $this->libraryAdress;
    }
}

class Shelf
{
    protected int $shelfNumber;
    protected int $shelfSize;
    protected $books = [];

    function __construct(int $shelfNumber, int $shelfSize) {}

    function addBookOnShelf(Book $book) {}
    function removeBookFromShelf(Book $book) {}
    function getBookFromShelf(int $number): Book
    {
        return $this->books[$number];
    }
}

class Room
{
    protected $roomNumber;
    protected $roomSize;
    protected $shelfs = [];

    function __construct(int $roomNumber) {}

    function addShelf(Shelf $shelf) {}
    function removeShelf(Shelf $shelf) {}
}

// =====  ex06  ========
//  a)  выводит 1234 т.к. static $x = 0; и у всех реализаций метода foo увеличивается на 1
//  б)  выводит 1234 т.к. B наследник класса А, в котором static $x = 0; для всех и увеличивается на 1