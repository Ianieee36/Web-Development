<!DOCTYPE html>
<html>
    <head>
        <title>MySQL Database Functions</title>
</head>
<body>
    <h1> Add Member Form </h1>

    <form action = "member_add.php" method = "post">
		<p>	<label for="fname">First Name:</label>
			<input type="text" name="fname" id="fname" required /></p>
		<p>	<label for="lname">Last Name:</label>
			<input type="text" name="lname" id="lname" required /></p>
		<p>	<label for="gender">Gender:</label>
			<select name ="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
</select>
        <p>	<label for="email">Email: </label>
			<input type="text" name="email" id="email" required/></p>
        <p>	<label for="phone">Phone: </label>
			<input type="text" name="phone" id="phone" required/></p>
        <p>	<input type="submit" value="Add Member" /></p>
	</form>

</body>
</html>