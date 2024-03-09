<?php
// Assume you have a Database class for database connection
require('php/db.php');

class EmailProviderFilter
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getEmailProviders()
    {
        $sql = "SELECT * FROM emails";
        $allData = $this->db->fetchData($sql);

        $emailProviders = [];
        foreach ($allData as $singleEntry) {
            $email = $singleEntry['email'];
            $provider = substr($email, strrpos($email, '@') + 1);
            $emailProviders[$provider] = true;
        }

        return $emailProviders;
    }

    public function filterByEmailProvider($selectedProvider)
    {
        $filteredData = [];
        if (!empty($selectedProvider)) {
            $filteredData = array_filter($this->getAllData(), function ($singleEntry) use ($selectedProvider) {
                $email = $singleEntry['email'];
                return strpos($email, '@' . $selectedProvider) !== false;
            });
        } else {
            $filteredData = $this->getAllData();
        }

        return $filteredData;
    }

    public function sortByEmail(&$data)
    {
        usort($data, function ($a, $b) {
            return strcasecmp($a['email'], $b['email']);
        });
    }

    public function sortByDate(&$data)
    {
        usort($data, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
    }

    private function getAllData()
    {
        $sql = "SELECT * FROM emails";
        return $this->db->fetchData($sql);
    }
    
}

