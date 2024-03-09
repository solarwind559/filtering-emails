<?php


class Sorter {
    private $data;

    public function __construct($data) {
        $this->data = $data;
        $this->connect = mysqli_connect('localhost', 'root', '', 'subscribers');

    }

    
    public function getDatabaseConnection() {
        return $this->connect;
    }

    public function sortByEmail() {
        usort($this->data, function ($a, $b) {
            return strcasecmp($a['email'], $b['email']);
        });
    }

    public function sortByDate() {
        usort($this->data, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
    }

    public function getEmails() {
        return $this->data;
    }
}
