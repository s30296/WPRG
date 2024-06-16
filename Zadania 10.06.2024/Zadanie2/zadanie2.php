<?php
interface Employee {
    function getSalary();
    function setSalary($salary);
    function getRole();
}

class Manager implements Employee {
    public $salary;
    public $role = "Manager";
    public $employees = [];

    function getSalary() {
        return $this->salary;
    }

    function setSalary($salary) {
        $this->salary = $salary;
    }

    function getRole() {
        return $this->role;
    }

    function addEmployee(Employee $employee) {
        $this->employees[] = $employee;
    }

    function getEmployees() {
        return $this->employees;
    }
}

class Developer implements Employee {
    public $salary;
    public $role = "Developer";
    public $programmingLanguage;

    function getSalary() {
        return $this->salary;
    }

    function setSalary($salary) {
        $this->salary = $salary;
    }

    function getRole() {
        return $this->role;
    }

    function setProgrammingLanguage($programmingLanguage) {
        $this->programmingLanguage = $programmingLanguage;
    }

    function getProgrammingLanguage() {
        return $this->programmingLanguage;
    }
}
class Designer implements Employee {
    public $salary;
    public $role = "Designer";
    public $designingTool;

    function getSalary() {
        return $this->salary;
    }

    function setSalary($salary) {
        $this->salary = $salary;
    }

    function getRole() {
        return $this->role;
    }

    function setDesigningTool($designingTool) {
        $this->designingTool = $designingTool;
    }

    function getDesigningTool() {
        return $this->designingTool;
    }
}

$manager = new Manager();
$developer = new Developer();
$designer = new Designer();

$developer->setSalary("10000");
$developer->setProgrammingLanguage("Java");
$manager->addEmployee($developer);

$designer->setSalary("8000");
$designer->setDesigningTool("Photoshop");
$manager->addEmployee($designer);

$manager->setSalary("12000");
$manager->addEmployee($manager);

$employees = $manager->getEmployees();
foreach ($employees as $employee) {
    echo "Rola: " . $employee->getRole() . "\n";
    echo "Wynagordzenie: " . $employee->getSalary() . "\n";
    if ($employee instanceof Developer) {
        echo "Jezyk Programowania: " . $employee->getProgrammingLanguage() . "\n";
    } elseif ($employee instanceof Designer) {
        echo "Narzedzie do Projektowania: " . $employee->getDesigningTool() . "\n";
    }
    echo "\n";
}
?>