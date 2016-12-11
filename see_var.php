<?php

/**
 * Lets you inspect variables. If no $var is defined, it will get all defined variables. 
 * @param mixed $var The variable to inspect.
 * @param string $name An optional display name for variable.
 * @param string $force Force an inspection type on the variable
 *  - options: 
 *      - dump: var_dump
 *      - print: print_r
 *      - auto: let method decide
 * @return void
 */
function see_var($var = 'all', $name = NULL, $force = 'auto') {
    echo "<pre>";

    if (strlen($name)) {
        echo $name . ':<br />';
    }

    if ($var !== 'all') {
        if ($force == 'dump') {
            var_dump($var);
        } elseif ($force == 'print') {
            print_r($var);
        } else {
            if (is_array($var)) {
                print_r($var);
            } else {
                var_dump($var);
            }
        }
    } else {
        print_r($GLOBALS);
    }

    echo "</pre>";
}

/**
 * Examples
 */
class Pet {

    public $name;
    public $species;
    public $type;
    public $birthday;
    private $vet = 'N/A';
    private $vaccinated = false;

    public function set_vet($name = '') {
        if (strlen($name)) {
            $this->vet = $name;
            $this->vaccinated = true;
        }
    }

    public function get_records() {
        return array('vet_name' => $this->vet, 'vaccinated' => $this->vaccinated);
    }

}

$pup = new Pet();
$pup->name = 'Mutt';
$pup->type = 'Dog';
$pup->species = 'Boston Terrier';
$pup->birthday = '01.01.12';

$pets = $example = array('cat', 'dog' => $pup, 'fish' => 'goldfish', 'animals' => 3);
$string = 'Who doesn\'t love having a pet?';
// Array //
see_var($example, 'pets');

// Class //
see_var($pets['dog'], 'Dog');

// Force //
$pup->set_vet('Dr.Vetly');
see_var($pup->get_records(), 'Pup - print', 'print');
see_var($pup->get_records(), 'Pup - dump', 'dump');
// String //
see_var($string, 'Example String');
