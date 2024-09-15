<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jsonFilePath = '../js/subscribers.json'; // Adjust this path if needed

// Function to read JSON data
function readJson($filePath) {
    if (!file_exists($filePath)) {
        die("File not found: " . $filePath);
    }
    $json = file_get_contents($filePath);
    return json_decode($json, true);
}

// Function to write JSON data
function writeJson($filePath, $data) {
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

// Load subscribers
$subscribers = readJson($jsonFilePath);

// Handle form submission for adding, updating, or deleting subscribers
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_subscriber'])) {
        $newSubscriber = [
            'id' => count($subscribers) + 1,
            'subscriber_name' => $_POST['subscriber_name'],
            'phone_number' => $_POST['phone_number'],
            'package' => $_POST['package'],
            'subscription_duration' => $_POST['subscription_duration'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'payment_status' => $_POST['payment_status'],
            'archived' => 0
        ];
        $subscribers[] = $newSubscriber;
        writeJson($jsonFilePath, $subscribers);
        echo json_encode(['success' => 'Subscriber added successfully.']);
        exit;
    }

    if (isset($_POST['update_subscriber'])) {
        foreach ($subscribers as &$subscriber) {
            if ($subscriber['id'] == $_POST['id']) {
                $subscriber['subscriber_name'] = $_POST['subscriber_name'];
                $subscriber['phone_number'] = $_POST['phone_number'];
                $subscriber['package'] = $_POST['package'];
                $subscriber['subscription_duration'] = $_POST['subscription_duration'];
                $subscriber['start_date'] = $_POST['start_date'];
                $subscriber['end_date'] = $_POST['end_date'];
                $subscriber['payment_status'] = $_POST['payment_status'];
                writeJson($jsonFilePath, $subscribers);
                echo json_encode(['success' => 'Subscriber updated successfully.']);
                exit;
            }
        }
    }

    if (isset($_POST['update_date'])) {
        foreach ($subscribers as &$subscriber) {
            if ($subscriber['id'] == $_POST['id']) {
                $subscriber[$_POST['field']] = $_POST[$_POST['field']];
                writeJson($jsonFilePath, $subscribers);
                echo json_encode(['success' => 'Date updated successfully.']);
                exit;
            }
        }
    }

    if (isset($_POST['change_status'])) {
        foreach ($subscribers as &$subscriber) {
            if ($subscriber['id'] == $_POST['id']) {
                $subscriber['payment_status'] = $_POST['status'];
                writeJson($jsonFilePath, $subscribers);
                echo json_encode(['success' => 'Payment status changed successfully.']);
                exit;
            }
        }
    }

    if (isset($_POST['archive'])) {
        foreach ($subscribers as &$subscriber) {
            if ($subscriber['id'] == $_POST['id']) {
                $subscriber['archived'] = 1;
                writeJson($jsonFilePath, $subscribers);
                echo json_encode(['success' => 'Subscriber archived successfully.']);
                exit;
            }
        }
    }

    if (isset($_POST['restore'])) {
        foreach ($subscribers as &$subscriber) {
            if ($subscriber['id'] == $_POST['id']) {
                $subscriber['archived'] = 0;
                writeJson($jsonFilePath, $subscribers);
                echo json_encode(['success' => 'Subscriber restored successfully.']);
                exit;
            }
        }
    }

    if (isset($_POST['delete'])) {
        $subscribers = array_filter($subscribers, function($subscriber) {
            return $subscriber['id'] != $_POST['id'];
        });
        writeJson($jsonFilePath, $subscribers);
        echo json_encode(['success' => 'Subscriber deleted successfully.']);
        exit;
    }
}

// Filter out archived subscribers for display
$activeSubscribers = array_filter($subscribers, function($subscriber) {
    return $subscriber['archived'] == 0;
});

$months = [];
foreach ($activeSubscribers as $subscriber) {
    $startMonth = date('F Y', strtotime($subscriber['start_date']));
    if (!isset($months[$startMonth])) {
        $months[$startMonth] = [];
    }
    $months[$startMonth][] = $subscriber;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subscribers</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="archive_subscribers.php">Archived Subscribers</a>
    </div>
    <div class="content">
        <h2>Manage Subscribers</h2>

        <!-- Add Subscriber Form -->
        <form id="add-subscriber-form">
            <h3>Add New Subscriber</h3>
            <input type="text" name="subscriber_name" placeholder="Subscriber Name" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <select name="package" required>
                <option value="">Select Package</option>
                <option value="Basic">Basic</option>
                <option value="Standard">Standard</option>
                <option value="Premium">Premium</option>
            </select>
            <input type="text" name="subscription_duration" placeholder="Subscription Duration" required>
            <input type="date" name="start_date" placeholder="Start Date" required>
            <input type="date" name="end_date" placeholder="End Date" required>
            <select name="payment_status" required>
                <option value="">Select Payment Status</option>
                <option value="Paid">Paid</option>
                <option value="Not Paid">Not Paid</option>
            </select>
            <button type="submit" class="btn-manage">Add Subscriber</button>
        </form>

        <?php foreach ($months as $month => $subscribers): ?>
        <div class="month-container">
            <h3 class="show-month"><?php echo htmlspecialchars($month); ?> <span class="arrow">&#9660;</span> <span
                    class="subscriber-count">(<?php echo count($subscribers); ?>)</span></h3>
            <table class="month-table">
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $subscriber): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subscriber['id']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['subscriber_name']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['package']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['subscription_duration']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($subscriber['end_date']); ?></td>
                        <td class="<?php echo $subscriber['payment_status'] == 'Paid' ? 'paid' : 'not-paid'; ?>">
                            <?php echo htmlspecialchars($subscriber['payment_status']); ?>
                        </td>
                        <td>
                            <button onclick="toggleEditForm(<?php echo $subscriber['id']; ?>)">Edit</button>
                            <button onclick="archiveSubscriber(<?php echo $subscriber['id']; ?>)">Archive</button>
                            <button onclick="deleteSubscriber(<?php echo $subscriber['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <tr id="edit-row-<?php echo $subscriber['id']; ?>" class="edit-row" style="display: none;">
                        <td colspan="9">
                            <form class="edit-form" data-id="<?php echo $subscriber['id']; ?>">
                                <input type="hidden" name="id" value="<?php echo $subscriber['id']; ?>">
                                <input type="text" name="subscriber_name"
                                    value="<?php echo htmlspecialchars($subscriber['subscriber_name']); ?>" required>
                                <input type="text" name="phone_number"
                                    value="<?php echo htmlspecialchars($subscriber['phone_number']); ?>" required>
                                <select name="package" required>
                                    <option value="Basic"
                                        <?php echo $subscriber['package'] == 'Basic' ? 'selected' : ''; ?>>Basic
                                    </option>
                                    <option value="Standard"
                                        <?php echo $subscriber['package'] == 'Standard' ? 'selected' : ''; ?>>Standard
                                    </option>
                                    <option value="Premium"
                                        <?php echo $subscriber['package'] == 'Premium' ? 'selected' : ''; ?>>Premium
                                    </option>
                                </select>
                                <input type="text" name="subscription_duration"
                                    value="<?php echo htmlspecialchars($subscriber['subscription_duration']); ?>"
                                    required>
                                <input type="date" name="start_date"
                                    value="<?php echo htmlspecialchars($subscriber['start_date']); ?>" required>
                                <input type="date" name="end_date"
                                    value="<?php echo htmlspecialchars($subscriber['end_date']); ?>" required>
                                <select name="payment_status" required>
                                    <option value="Paid"
                                        <?php echo $subscriber['payment_status'] == 'Paid' ? 'selected' : ''; ?>>Paid
                                    </option>
                                    <option value="Not Paid"
                                        <?php echo $subscriber['payment_status'] == 'Not Paid' ? 'selected' : ''; ?>>Not
                                        Paid</option>
                                </select>
                                <button type="button" class="btn-manage" onclick="updateSubscriber(this)">Save
                                    Changes</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    $(document).ready(function() {
        $('.show-month').click(function() {
            $(this).next('.month-table').slideToggle();
            $(this).find('.arrow').toggleClass('rotated');
        });

        $('#add-subscriber-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize() + '&add_subscriber=1';

            $.post('', formData, function(response) {
                alert(response.success);
                location.reload();
            }, 'json');
        });
    });

    function toggleEditForm(id) {
        $('#edit-row-' + id).toggle();
    }

    function updateSubscriber(button) {
        var form = $(button).closest('.edit-form');
        var formData = form.serialize() + '&update_subscriber=1';

        $.post('', formData, function(response) {
            alert(response.success);
            location.reload();
        }, 'json');
    }

    function archiveSubscriber(id) {
        if (confirm('Are you sure you want to archive this subscriber?')) {
            $.post('', {
                id: id,
                archive: 1
            }, function(response) {
                alert(response.success);
                location.reload();
            }, 'json');
        }
    }

    function deleteSubscriber(id) {
        if (confirm('Are you sure you want to delete this subscriber?')) {
            $.post('', {
                id: id,
                delete: 1
            }, function(response) {
                alert(response.success);
                location.reload();
            }, 'json');
        }
    }
    </script>
</body>

</html>