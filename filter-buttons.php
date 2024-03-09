<?php

// require('php/db.php');
require('php/sorter.php');
require('php/filter-buttons.php');


$db = new Database();
$sql = "SELECT * FROM emails";
$data = $db->fetchData($sql);

// Usage example:
$emailProviderFilter = new EmailProviderFilter();
$emailProviders = $emailProviderFilter->getEmailProviders();
$selectedProvider = $_POST['provider'] ?? ''; // Get selected provider from form submission

// Filter the data based on the selected provider
$filteredData = $emailProviderFilter->filterByEmailProvider($selectedProvider);


// Create a sorter instance and sort by date (default)
$emailSorter = new Sorter($filteredData);
$emailSorter->sortByDate();

// Check if sorting option is provided
if (isset($_GET['sort'])) {
    if ($_GET['sort'] === 'email') {
        $emailSorter->sortByEmail();
    } elseif ($_GET['sort'] === 'date') {
        $emailSorter->sortByDate();
    }
}

// Get the sorted emails
// $sortedData = $emailSorter->getEmails();
$filteredAndSortedData = $emailSorter->getEmails();


?>

<body>
    <!-- Display filter buttons -->
    <p>Sort by:</p>
    <form method="post">
        <?php
        foreach (array_keys($emailProviders) as $provider) {
            echo '<button type="submit" name="provider" value="' . $provider . '">' . ucfirst($provider) . '</button> ';
        }
        ?>
    </form>

   <!-- Display sorting options -->
   <p>Sort by:
        <a href="?sort=email">Email</a>
        <a href="?sort=date">Date</a>
    </p>

<!-- Display the sorted data in an HTML table -->
<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($filteredAndSortedData as $entry) {
            echo '<tr>';
            echo '<td>' . $entry['email'] . '</td>';
            echo '<td>' . $entry['date'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>





</body>
