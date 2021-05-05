<?php declare(strict_types=1);

class Hero {
    protected string $name;
    protected bool $type;
    protected int $energy;
    
    public final function __construct(string $name, bool $type, int $energy) {
        $this->name = $name;
        $this->type = $type;
        $this->energy = $energy;
    }
    
    public final function useElixir(Elixir $elixir) {
        $energy = $elixir->use();
        
        if ($energy)
            echo ($this->type ? 'Хороший' : 'Поганий') . " супергерой $this->name використав еліксир і тепер " .
               (($this->energy += $energy) > 1 ?
               "має енергію $this->energy.<br>\n"
               :
               "знесилений.<br>\n");
    }
}

class BadGuy extends Hero {
    private int $bullets = 0;
    
    public function fire() : void
    {
        echo
            !$this->bullets || !$this->bullets-- ?
                "Потрібна перезарядка!<br>\n" : "ПІФ-ПАФ!<br>\n";
    }
    
    public function chargeGun() : void
    {
        $this->bullets = 30;
    }
}

class Sage extends Hero {
    private array $phrases = ['Наполегливість безцінна.', 'Друг всім — нічий друг.', 'Виживає не найсильніший, а найчутливіший до змін.'];
    
    public function ask(string $question) : void
    {
        echo
            'На питання "' . $question .
            '" я відповім так: <i><u>' .
            $this->phrases[array_rand($this->phrases)] .
            '</u></i><br>' . PHP_EOL;
    }

}

class Alchemist extends Hero {
    public function createElixir(int $energy) : Elixir {
        return new Elixir($energy);
    }
    
}

class Elixir {
    private int $energy;
    
    public function __construct(int $energy) {
        $this->requireInstance('Alchemist'); // Тільки алхіміки можуть варити еліксири
        
        $this->energy = $energy;
    }

    public function use() : int
    {
        $this->requireInstance('Hero'); // Лише супергероям можна їх використовувати
        
        $energy = $this->energy;
        $this->energy += -$energy;
        
        if(!$energy) echo "Еліксир вже використано...<br>\n";
        
        return $energy;
    }
    
    private function requireInstance(string $required_caller) : void
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $caller = $backtrace[array_key_last($backtrace)]['class'];
        
        if(!is_a($caller, $required_caller, true))
            throw new BadMethodCallException("Caller instance isn't $required_caller.");
    }
}

$doctor_evil = new BadGuy('Доктор Зло', false, 1000);
$doctor_evil->fire();
$doctor_evil->chargeGun();
$doctor_evil->fire();

$mathematician = new Sage('Математик', true, 90);
$mathematician->ask('Скільки буде 2 + 2?');
$mathematician->ask('А 5 х 5?');

$mary = new Alchemist('Мері', true, 100);
$elixir = $mary->createElixir(100);
$elixir2 = $mary->createElixir(-1000222);

$mary->useElixir($elixir);
$mary->useElixir($elixir);

$doctor_evil->useElixir($elixir2);
