<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "club");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize form data variables
$name = $email = $phone = $address = $dob = $gender = $membership_type = $skills = "";
$form_submitted = false; // Flag to check if the form is submitted

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $membership_type = $_POST['membership_type'];
    $skills = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "";

    // Insert the member into the database
    $sql = "INSERT INTO members (name, email, phone, address, dob, gender, membership_type, skills) 
            VALUES ('$name', '$email', '$phone', '$address', '$dob', '$gender', '$membership_type', '$skills')";

    if ($conn->query($sql) === TRUE) {
        $message = "Member registered successfully!";
        $form_submitted = true; // Set flag to true when the form is submitted successfully
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Membership Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .message {
            text-align: center;
            color: green;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Club Membership Registration</h1>

        <!-- Show success/error message -->
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Show the entered data after successful registration -->
        <?php if ($form_submitted): ?>
            <h2>Submitted Data</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($address)); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
            <p><strong>Membership Type:</strong> <?php echo htmlspecialchars($membership_type); ?></p>
            <p><strong>Skills/Interests:</strong> <?php echo htmlspecialchars($skills); ?></p>
        <?php else: ?>
            <!-- Registration Form -->
            <form action="" method="POST" class="registration-form">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>

                <label for="address">Address:</label>
                <textarea name="address" id="address" required></textarea>

                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob" required>

                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label for="membership_type">Membership Type:</label>
                <select name="membership_type" id="membership_type" required>
                    <option value="Regular">Regular</option>
                    <option value="Premium">Premium</option>
                    <option value="VIP">VIP</option>
                </select>

                <label for="skills">Skills/Interests:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="skills[]" value="Sports"> Sports</label>
                    <label><input type="checkbox" name="skills[]" value="Music"> Music</label>
                    <label><input type="checkbox" name="skills[]" value="Art"> Art</label>
                    <label><input type="checkbox" name="skills[]" value="Technology"> Technology</label>
                </div>

                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
