<?php
include 'include.php';

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_TEXT
	<form method="post" action="$_SERVER[PHP_SELF]">

	<fieldset>
	<legend>First/Last Names:</legend><br/>
	<input type="text" name="f_name" size="30" maxlength="75" required="required" />
	<input type="text" name="l_name" size="30" maxlength="75" required="required" />
	</fieldset>

	
	<fieldset>
	<legend>Email Address:</legend><br/>
	<input type="email" name="email" size="30" maxlength="150" />
	</fieldset>

	<p><label for="note">Personal Note:</label><br/>
	<textarea id="note" name="note" cols="35" rows="3"></textarea></p>

	<button type="submit" name="submit" value="send">Add Entry</button>
	</form>
END_OF_TEXT;

} else if ($_POST) {
	//time to add to tables, so check for required fields
	if (($_POST['f_name'] == "") || ($_POST['l_name'] == "")) {
		header("Location: addentry.php");
		exit;
	}

	//connect to database
	doDB();

	//create clean versions of input strings
	$safe_f_name = mysqli_real_escape_string($mysqli, $_POST['f_name']);
	$safe_l_name = mysqli_real_escape_string($mysqli, $_POST['l_name']);
	$safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$safe_note = mysqli_real_escape_string($mysqli, $_POST['note']);

	//add to master_name table
	$add_master_sql = "INSERT INTO master_name (f_name, l_name)
                       VALUES ('".$safe_f_name."', '".$safe_l_name."')";
	$add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));

	//get master_id for use with other tables
	$master_id = mysqli_insert_id($mysqli);

	if ($_POST['email']) {
		//something relevant, so add to email table
		$add_email_sql = "INSERT INTO email (master_id, email)  VALUES ('".$master_id."', '".$safe_email."')";
		$add_email_res = mysqli_query($mysqli, $add_email_sql) or die(mysqli_error($mysqli));
	}

	if ($_POST['note']) {
		//something relevant, so add to notes table
		$add_note_sql = "INSERT INTO personal_notes(master_id, note) VALUES ('".$master_id."', '".$safe_note."')";
		$add_note_res = mysqli_query($mysqli, $add_note_sql) or die(mysqli_error($mysqli));
	}
	mysqli_close($mysqli);
	$display_block = "<p>Your entry has been added.  Would you like to <a href=\"addentry.php\">add another</a>?</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add an Entry</title>
</head>
<body>
<h1>Add an Entry</h1>
<?php echo $display_block; ?>
</body>
</html>