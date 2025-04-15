<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

$title = "Admin Chat";
include_once '../includes/header_admin.php'; // Include admin header
include_once '../includes/db.php'; // Include database connection

// Handle message sending as admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msg'])) {
    $adminUsername = 'admin'; // Admin username
    $message = htmlspecialchars(trim($_POST['msg']));

    if ($message !== "") {
        $query = "INSERT INTO chat_messages (user_id, message, is_admin) VALUES (:user_id, :message, TRUE)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $adminUsername); // Use a constant value for admin ID or set it based on your logic
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }
}

// Fetch all chat messages
$query = "SELECT * FROM chat_messages ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div id="limit">
    <h2>Query Chat</h2>
    <div id="chats" style="border: 1px solid #ccc; height: 300px; overflow-y: scroll; padding: 10px;">
        <?php foreach ($messages as $message): ?>
            <div class="<?php echo ($message['is_admin']) ? 'adchatmsg' : 'chatmsg'; ?>">
                <strong><?php echo htmlspecialchars($message['user_id']); ?>:</strong>
                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                <span class="time"><?php echo htmlspecialchars(substr($message['created_at'], 0, 16)); ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="" method="POST" class="chatinput">
        <input type="text" name="msg" id="msg" placeholder="Type your message here..." required>
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-send">Send</span></button>
    </form>

    <form action="deletechat.php" method="GET">
        <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Delete all chat</button>
        <a href="index.php" class="btn btn-primary" style="margin-top: 10px; padding:10px 20px;">Home</a>
    </form>
</div>

<style>


/* Chat Container */
#limit {
    height: 70vh;
    width: 70%; /* Maximum width for the chat container */
    margin: 20px auto; /* Center the container */
    /* background-color: white; White background for the chat area */
    background-color: transparent;
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 15px; /* Padding inside the container */
}

/* Chat Header */
h2 {
    text-align: center; /* Center the title */
    color: #fff; /* Dark text color for visibility */
    margin-bottom: 5vh;
}

/* Chat Messages Area */
#chats {
    border: 1px solid #ccc; /* Light gray border around chat area */
    height: 300px; /* Fixed height with scroll */
    overflow-y: auto; /* Enable vertical scrolling */
    padding: 10px; /* Padding inside chat area */
    background-color: #f9f9f9; /* Slightly darker background for messages */
}

/* Individual Chat Messages */
.chatmsg {
    background-color: #075bff; /* Blue background for user messages */
    border-radius: 10px; /* Rounded corners for messages */
    padding: 8px; /* Padding inside message bubbles */
    color: white; /* White text color for contrast */
    margin-bottom: 5px; /* Space between messages */
}

.adchatmsg {
    background-color: #5FCF80; /* Green background for admin messages */
    border-radius: 10px;
    padding: 8px;
    color: white;
    margin-bottom: 5px;
}

/* Time Stamp Style */
.time {
    font-size: 12px; /* Smaller font size for timestamps */
    color: gray; /* Gray color for timestamps to differentiate from messages */
}

/* Input Form Styles */
.chatinput {
    margin-top: 5vh;
    display: flex; /* Flexbox layout for input and button alignment */
}

input[type="text"] {
    max-width: 700px;
    height: 40px;
    flex-grow: 1; /* Allow input to take available space */
    padding: 10px; /* Padding inside input field */
    border-radius: 5px; /* Rounded corners for input field */
    border: 1px solid #ccc; /* Light gray border around input field */
}

button {
    padding: 10px 30px;
    margin-left: 10px; /* Space between input and button */
}

/* Button Styles */
.btn-success {
    background-color: #28a745; /* Green button for sending messages */
}

.btn-danger {
    background-color: #dc3545; /* Red button for deleting chat messages */
}

.btn-primary {
    background-color: #007bff; /* Blue button for home link */
}

/* Responsive Design Adjustments */
@media (max-width: 600px) {
    #limit {
        width: 95%; /* Full width on smaller screens for better usability */
        margin-top: 10px; /* Adjust top margin on smaller screens */
        padding: 10px; /* Adjust padding on smaller screens */
    }

    .chatinput {
        flex-direction: column; /* Stack input and button vertically on small screens */
        align-items: stretch; /* Stretch buttons to full width on small screens */
        margin-top: 10px; /* Add space above input form on small screens */
    }

    button {
        width: 100%; /* Full width buttons on small screens for easier tapping */
        margin-left: 0; /* Remove left margin on small screens */
        margin-top: 5px; /* Add top margin for spacing between stacked buttons */
    }
}

</style>

<script>
// Function to update chat messages in real-time
function displayChat() {
   $.ajax({
       url: "chatdisplay.php", // This file will fetch and return chat messages
       method: "GET",
       success: function(data) {
           $("#chats").html(data);
           $("#chats").scrollTop($("#chats")[0].scrollHeight); // Scroll to bottom
       }
   });
}

setInterval(displayChat, 1000); // Update every second
</script>

<?php include_once '../includes/footer.php'; // Include footer ?>
