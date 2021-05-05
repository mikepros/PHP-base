<?php declare(strict_types=1);

class BookShop {
    private array $books = [];
    
    public function add(Book $book) {
        $this->books[] = $book;
    }
    
    public function showGenresPricesSum () : void
    {
        $genresSummary = [];

        // Заповнення масиву $genresSummary
        array_walk($this->books, function ($book) use (&$genresSummary) {
        // Створення елемента (якщо такого ще немає) з ключем, що дорівнює жанру поточної книги
        // та зі значенням - 0.
            if(!isset($genresSummary[$book->genre]))
                $genresSummary[$book->genre] = 0;
            // Сумування цін кних, у яких спільний жанр;
            $genresSummary[$book->genre] += $book->price;
        });
        
        foreach ($genresSummary as $genre => $sum)
            echo "Загальна вартість книг жанру <i>\"$genre\"</i>: $sum<br>\n";
    }
}

class Book {
    private string $name, $author, $genre;
    private int $price;
    
    public function __construct(string $name, string $author, string $genre, int $price) {
        $this->name = $name;
        $this->author = $author;
        $this->genre = $genre;
        $this->price = $price;
    }
    
    public function __get($name) {
        return $this->$name;
    }
}


$shop = new BookShop;

foreach(
    [
        ['Цифрова фортеця','Ден Браун', 'Детектив', 200],
        ['Айвенго','Вальтер Скотт','Історичний роман', 600],
        ['Доктор Сон', 'Стівен Кінг', 'Жахи', 250],
        ['Алхімік', 'Пауло Коельйо', 'Роман', 130],
        ['Чорний ворон. Залишенець', 'Василь Шкляр', 'Історичний роман', 160]
    ] as $book)
        $shop->add(new Book(...$book));

$shop->showGenresPricesSum();