<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Contact Me</title>
    </head>

    <body>
        <?php 

            /*
                function that checks if $data is empty or not.
                $errorCount is a global variable.
                if $data is empty, a message with $fieldName will be shown as a required field, also $errorCount will be incremented
                and $retval is returned as "".
                otherwise $retval will be returned as data that is trimmed and stripped of backslashes.
            */
            function validateInput($data, $fieldName) {
                global $errorCount;
                if (empty($data)) {
                    echo "\"$fieldName\" is a required field. <br />\n";
                    ++$errorCount;
                    $retval = "";
                } else {
                    $retval = trim($data);
                    $retval = stripslashes($retval);
                }
                return($retval);
            }

            /* 
                function that validates the email.
                $errorCount is a global variable.
                if $data is empty, a message will be shown saying $fieldName is a required field, $errorCount will be incremented
                and $retval is returned as "".
                otherwise $retval will be the filtered version of $data and then checked to see if it is a valid email address.
                if it is not a valid email address, a message will be shown.
                if it is valid it will be returned.
            */
            function validateEmail($data, $fieldName) {
                global $errorCount;

                if (empty($data)) {
                    echo "\"$fieldName\" is a required field. <br />\n";
                    ++$errorCount;
                    $retval ="";
                } else {
                    $retval = filter_var($data, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($retval, FILTER_VALIDATE_EMAIL)) {
                        echo "\"$fieldName\" is not a valid e-mail address. <br />\n";
                    }
                }

                return($retval);
            }

            /*
                displays the form and creates it as a sticky form.
                this creates the form you will see when visiting the web page.
                a sticky form is when the input boxes holds the information filled in when an error occurs.
                inputs are put in the form tab to relay the information later on.
            */
            function displayForm($Sender, $Email, $Subject, $Message) {
                 ?> <h2 style = "text-align:center">Contact Me</h2>
                    <form name="contact" action="ContactForm.php" method="post">
                        <p>Your Name:
                            <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
                        <p>Your E-mail:
                            <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
                        <p>Subject:
                            <input type="text" name="Subject" value ="<?php echo $Subject; ?>" /></p>
                        <p>Message: <br />
                            <textarea name="Message"><?php echo $Message; ?></textarea></p>
                        <p>
                            <input type="reset" value="Clear Form" />&nbsp; &nbsp;
                            <input type="submit" name="Submit" value="Send Form" /></p>
                    </form>
                    <?php
            }

            //variables initialized to prevent undefined variable errors
            $ShowForm = TRUE;
            $errorCount = 0;
            $Sender = "";
            $Email = "";
            $Subject = "";
            $Message = "";

            /*
                isset function checks if the $_POST array, if the key 'submit' exists and is not null.
                also checks if the submit was pressed.
                the recently added variables are filled with validated data returned from the validateInput and validateEmail functions.
                if the global $errorCount is 0, $ShowForm will = false, otherwise $ShowForm will be true.
            */
            if (isset($_POST['Submit'])) {
                $Sender = validateInput($_POST['Sender'], "Your Name");
                $Email = validateEmail($_POST['Email'], "Your E-mail");
                $Subject = validateInput($_POST['Subject'], "Subject");
                $Message = validateInput($_POST['Message'], "Message");
                if ($errorCount == 0 )
                    $ShowForm = FALSE;
                else
                    $ShowForm = TRUE;
            }

            /*
                if $ShowForm is true an error message will be shown and the form will be redisplayed.
                otherwise a mail will be sent to me. I think we send a copy of the email to the sender, so they can check if its accurate.
                if $result comes back as true, a confirmation message will be displayed, otherwise an error message will appear.
            */
            if ($ShowForm == TRUE) {
                if ($errorCount > 0)
                    echo "<p>Please re-enter the form information below.</p>\n";
                    displayForm($Sender,$Email,$Subject,$Message);
            } else {
                $SenderAddress = "$Sender <$Email>";
                $Headers = "From: $SenderAddress\nCC: $SenderAddress\n";

                $result = mail("hongharold3469@gmail.com", $Subject, $Message, $Headers);

                if ($result)
                    echo "<p>Your message has been sent. Thank you, " . $Sender . ".</p>\n";
                else
                    echo "<p>There was an error sending your message, " . $Sender . ".</p>\n";
            }

            /* 
                My Reflections:
                I am quite amazed at the way this php form was created.
                The way they count errors is new to me.
                I am wondering if they can do more with the $errorCount.
                One problem I noticed is when you press clear form on a "sticky" input box it will not clear it but it will return the previous value.
                I was confused about all the code until I watched the youtube videos that were posted in canvas. The videos helped me understand the process of the forms.
            */

        ?>
    </body>
</html>