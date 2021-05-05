<?php declare(strict_types=1);

class Student {
    private array $skills = [];
    
    public function __construct(private string $name) {}
    
    public function hasSkill(string $skill) : bool 
    {
        return in_array($skill, $this->skills);
    }
    
    public function addSkill(string $skill) : void
    {
        if(!$this->hasSkill($skill, $this->skills))
            $this->skills[] = $skill;
    }
}

$students = [];

foreach (
    ['Tom' => 'CSS' , 'Jack' => 'PHP', 'Simon' => 'HTML', 'Mike' => 'PHP']
    as $name => $skill
)
    ($students[] = new Student($name))
        ->addSkill($skill);

$skill = 'PHP';
$students_count = 0;

foreach ($students as $student)
    if ($student->hasSkill($skill))
        $students_count++;

echo "Кількість студентів, які знають $skill: $students_count.";