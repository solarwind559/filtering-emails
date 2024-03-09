<?php

require('oop/sorter.php');
require('oop/filter-buttons.php');

$db = new Database();
$sql = "SELECT * FROM emails";
$data = $db->fetchData($sql);

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
$filteredAndSortedData = $emailSorter->getEmails();

?>

<body>
    <!-- Display filter buttons -->
    <p>Show only:</p>
    <form method="post">
        <?php
        foreach (array_keys($emailProviders) as $provider) {
            echo '<button type="submit" name="provider" value="' . $provider . '">' . ucfirst($provider) . '</button> ';
        }
        ?>
    </form>

   <!-- Display sorting options -->
   <p>Sort by: </p>
   <button><a href="?sort=email">Email</a></button>
   <button><a href="?sort=date">Date</a></button>
        
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
