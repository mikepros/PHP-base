<?php declare(strict_types=1);

 class Car {
    private int $fuel = 2;
    
    public function __construct(
        private string $model,
        private string $color,
        private int $price,
        private int $year
    ) {}
    
    public function go() : void
    {
        echo
            !$this->fuel || !$this->fuel-- ?
                "Порожній бак <br>\n" : "Я їду<br>\n";
    }
    
    public function __get($name) {
        return $this->$name;
    }
}

$cars = [
    new Car('Aston Martin', 'white', 20000, 1978),
    new Car('BMW', 'red', 7000, 2005),
    new Car('Cadillac', 'black', 17000, 2015),
    new Car('Dodge', 'black', 19000, 2020)
];

$cars[0]->go();
$cars[0]->go();
$cars[0]->go();

foreach ($cars as $car)
    if (
        $car->price < 20000 && $car->price > 15000
        and
        $car->color === 'black'
        and
        $car->year - date('Y') < 8
    )
        echo "Ціна автомобіля $car->model: $car->price<br>\n";
        
