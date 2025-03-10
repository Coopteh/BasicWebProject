<?php

class User {
    private $name;
    private $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function introduce() {
        return "Привет, я " . $this->name . ".";
    }
}

class Admin extends User {
    public function manage() {
        return "У меня есть права администратора.";
    }

    public function introduce() {
        $parentIntroduction = parent::introduce();
        return $parentIntroduction . " Я администратор.";
    }
}

// Пример использования
$user = new User("Алексей", "alexey@example.com");
echo $user->introduce(). "<br>". "\n"; // Привет, я Алексей.
$admin = new Admin("Мария", "maria@example.com");
echo $admin->introduce(). "<br>". "\n"; // Привет, я Мария. Я администратор.
echo $admin->manage(); // У меня есть права администратора.
?>