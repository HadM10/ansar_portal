<?php
$jsonFilePath = '../js/subscribers.json';

// Function to read JSON data
function readJson($filePath)
{
    $json = file_get_contents($filePath);
    return json_decode($json, true);
}

// Function to write JSON data
function writeJson($filePath, $data)
{
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}
// Function to update subscriber status
function updateSubscriber($filePath, $id, $action)
{
    $subscribers = readJson($filePath);
    foreach ($subscribers as &$subscriber) {
        if ($subscriber['id'] == $id) {
            if ($action == 'restore') {
                $subscriber['archived'] = 0;
                $subscriber['archived_date'] = null; // Clear archived_date on restore
            } elseif ($action == 'delete') {
                $subscriber['archived'] = -1; // Mark as deleted
            } else {
                $subscriber['archived'] = 1;
                $subscriber['archived_date'] = date('F Y'); // Set the current month and year
            }
            break;
        }
    }
    writeJson($filePath, $subscribers);
    return ['success' => 'Operation successful'];
}

// Handle restore or delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['restore']) ? 'restore' : 'delete';
    $id = $_POST['id'];
    $response = updateSubscriber($jsonFilePath, $id, $action);
    echo json_encode($response);
    exit;
}

$subscribers = readJson($jsonFilePath);
$archivedSubscribers = array_filter($subscribers, function ($subscriber) {
    return $subscriber['archived'] == 1;
});
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Subscribers</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="manage_subscribers.php">Manage Subscribers</a>
        <a href="https://ansarportal-deaa9ded50c7.herokuapp.com/index.php">Go Back</a>
    </div>
    <div class="content">
        <h2>Archived Subscribers</h2>
        <table class="subscriber-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subscriber Name</th>
                    <th>Phone Number</th>
                    <th>Package</th>
                    <th>Subscription Duration</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Payment Status</th>
                    <th>Archived Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($archivedSubscribers as $subscriber): ?>
                    <tr class="<?php echo $subscriber['payment_status'] === 'Paid' ? 'paid' : 'not-paid'; ?>">
                        <td><?php echo $subscriber['id']; ?></td>
                        <td><?php echo $subscriber['subscriber_name']; ?></td>
                        <td><?php echo $subscriber['phone_number']; ?></td>
                        <td><?php echo $subscriber['package']; ?></td>
                        <td><?php echo $subscriber['subscription_duration']; ?></td>
                        <td><?php echo $subscriber['start_date']; ?></td>
                        <td><?php echo $subscriber['end_date']; ?></td>
                        <td><?php echo $subscriber['payment_status']; ?></td>
                        <td>
                            <?php echo isset($subscriber['archived_date']) ? 'Archived: ' . htmlspecialchars($subscriber['archived_date']) : 'Archived: N/A'; ?>
                        </td>
                        <td>
                            <button class="restore"
                                onclick="restoreSubscriber(<?php echo $subscriber['id']; ?>)">Restore</button>
                            <button class="delete"
                                onclick="deleteSubscriber(<?php echo $subscriber['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function restoreSubscriber(id) {
            if (confirm('Are you sure you want to restore this subscriber?')) {
                $.post('archive_subscribers.php', {
                    restore: 1,
                    id: id
                }, function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert(res.success);
                        location.reload(); // Reload to see the updated list
                    } else {
                        alert(res.error);
                    }
                });
            }
        }

        function deleteSubscriber(id) {
            if (confirm('Are you sure you want to delete this subscriber?')) {
                $.post('archive_subscribers.php', {
                    delete: 1,
                    id: id
                }, function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert(res.success);
                        location.reload(); // Reload to see the updated list
                    } else {
                        alert(res.error);
                    }
                });
            }
        }
    </script>
</body>

</html>