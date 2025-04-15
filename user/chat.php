<?php
session_start();
$title = "Chat";
include_once '../includes/user_header.php'; // Include header
include_once '../includes/db.php'; // Include database connection

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msg'])) {
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session
    $message = htmlspecialchars(trim($_POST['msg']));

    if ($message !== "") {
        $query = "INSERT INTO chat_messages (user_id, message, is_admin) VALUES (:user_id, :message, FALSE)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }
}

// Fetch chat messages
$query = "SELECT * FROM chat_messages ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<style>
/* General Styles */


/* Chat Container */
#limit {
    max-width: 900px;
    height: 70vh;
    margin: 20px auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

/* Chat Header */
h2 {
    text-align: center;
    color: #333;
}

/* Chat Messages Area */
#chats {
    border: 1px solid #ccc;
    height: 500px;
    overflow-y: scroll;
    padding: 10px;
    background-color:rgba(62, 57, 57,0.3);
}

/* Individual Chat Messages */
.chatmsg {
    background-color: #075bff; /* User messages */
    border-radius: 10px;
    padding: 8px;
    color: white;
    margin-bottom: 5px;
}

.adchatmsg {
    background-color: #5FCF80; /* Admin messages */
    border-radius: 10px;
    padding: 8px;
    color: white;
    margin-bottom: 5px;
}

/* Time Stamp */
.time {
    font-size: 12px;
    color: gray;
}

/* Input Form Styles */
.chatinput {
    margin-top: 2vh;
    display: flex;
    justify-content: space-between; /* Align input and button */
}

input[type="text"] {
    flex-grow: 1; /* Allow input to take available space */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    margin-left: 10px; /* Space between input and button */
}

/* Button Styles */
.btn-success {
border-radius: 5px;
padding: 0 20px 0 20px;
    background-color: #28a745; /* Green button for sending messages */
}

.btn-danger {
    margin-top: 10vh;
    border-radius: 5px;
    padding: 5px 20px 5px 20px;
    background-color: #dc3545; /* Red button for deleting chat */
}

.btn-primary {
    text-decoration: none;
    color:#fff;
    margin-top: 10vh;
    border-radius: 5px;
    padding: 5px 20px 5px 20px;
    background-color: #007bff; /* Blue button for home link */
}

/* Responsive Design */
@media (max-width: 600px) {
    #limit {
        width: 95%; /* Full width on smaller screens */
        margin-top: 10px; /* Adjust top margin for smaller screens */
    }

    .chatinput {
        flex-direction: column; /* Stack input and button on small screens */
        align-items: stretch; /* Stretch buttons to full width */
        margin-top: 10px; /* Add space above input form on small screens */
    }

    button {
        width: 100%; /* Full width buttons on small screens */
        margin-left: 0; /* Remove left margin on small screens */
        margin-top: 5px; /* Add top margin for spacing */
    }
}

</style>


<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div id="limit">
    <h2>Live Query</h2>
    <div id="chats" style="border: 1px solid #ccc; height: 300px; overflow-y: scroll; padding: 10px;">
        <?php foreach ($messages as $message): ?>
            <div class="<?php echo ($message['is_admin']) ? 'adchatmsg' : 'chatmsg'; ?>">
                <strong><?php echo htmlspecialchars($message['user_id'] == $_SESSION['user_id'] ? 'You' : 'Admin'); ?>:</strong>
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
        <a href="user_dashboard.php" class="btn btn-primary" style="margin-top: 10px;">Home</a>
    </form>
</div>

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
