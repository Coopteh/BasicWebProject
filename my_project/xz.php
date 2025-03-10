<?php

class User {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function introduce() {
        return "Меня зовут " . $this->name . ".";
    }
}

class Admin extends User {
    public function introduce() {
        return parent::introduce() . " Я администратор.";
    }
}

// Проверка
$admin = new Admin("Иван");
echo $admin->introduce(); // "Меня зовут Иван. Я администратор."
?>