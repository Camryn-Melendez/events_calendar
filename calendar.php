<html>
<head>
    <link rel="stylesheet" href="calendar.css" type="text/css"/>
    <title>Events Calendar</title>
</head>
<body>

<?php

    //Initialize variables.
    $name              = "";
    $event_name        = "";
    $event_description = "";
    $start             = "";
    $end               = "";

    //Connect to database.
    $link = mysqli_connect( "localhost", "root", "root", "events_calendar" );

    // Check connection
    if ( $link === false ) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
?>

<div class="submit-message">
    <?php
        //Checks if the form has been submitted.
        if ( array_key_exists( 'submit', $_POST ) ) {
            $name = $_POST[ 'name'];
            $event_name = $_POST[ 'event-name'];
            $event_description = $_POST[ 'event-description'];
            $start = $_POST[ 'start'];
            $end = $_POST[ 'end'];

            // Attempt insert query execution.
            $sql = "INSERT INTO events_calendar ( name, eventName, eventDescription, start, end ) 
                    VALUES ( '$name', '$event_name', '$event_description', '$start', '$end' ) ";
            if ( mysqli_query( $link, $sql )) {
                echo "Event created successfully. Thank you $name.";
            } else {
                echo "ERROR: Unable to execute $sql. " . mysqli_error( $link );
            }
        }
    ?>
</div>




<div class="events-register-form"> 
    <h2>Create an Event</h2>
    <form ID="events-register-form" name="events-register-form" action="calendar.php" method="post">

        <div class="name">
            <label ID="name-label"> Name </label> <br>
            <input name="name" ID="name" type="text" value="" required> 
        </div>

        <div class="event-name">
            <label ID="event-name-label"> Event Name </label> <br>
            <input name="event-name" ID="event-name" type="text" value="" required> <br>
        </div>

        <div class="event-description">
            <label ID="event-description-label"> Event Description </label> <br>
            <textarea name="event-description" ID="event-description-input" rows="4" cols="25" value="" required></textarea> <br>
        </div>

        <div class="start">
            <label ID="start-label"> Start Day/Time </label> <br>
            <input name="start" ID="start" type="datetime-local" value="" required> <br>
        </div>

        <div class="end">
            <label ID="end-label"> End Day/Time </label> <br>
            <input name="end" ID="end" type="datetime-local" value="" required> 
        </div> <br>

        <input ID="submit" type="submit" value="submit" name="submit"> 
</form>
</div>

<h2>Events Calendar</h2>

<?php 
    //Select the submitted events data.
    $sql1 = "SELECT * FROM events_calendar";
    $result = mysqli_query( $link, $sql1);
    //Get the number of rows in the table.
    $num_rows = mysqli_num_rows( $result );

    if ( $num_rows == 0 ) { ?>
        <p class="no-events-yet"> no events yet.. </p>
        <?php } 

    //Iterate through the rows
    for ($i = 0; $i < $num_rows; $i++) {
        //Get a row from the sql result.
        $row = mysqli_fetch_array( $result );
        //Get the values from this row.
        $this_name = $row[ 'name' ];
        $this_event = $row[ 'eventName' ];
        $this_description = $row[ 'eventDescription' ];
        $this_start = $row[ 'start' ];
        $this_end = $row[ 'end' ]; ?>

        <div class="event-listing">
            <h3 class="event-listing-title"><?php echo $this_event?></h3>
            <p class="event-listing-subtitle">Event created by:<?php echo " $this_name"?></p>
            <div class="event-listing-description">
                <p><?php echo $this_description?></p>
            </div> 
            <p class="event-listing-time">Starts:<?php echo "  " . $this_start?><br>Ends:<?php echo "  " . $this_end?></p>
        </div>

    <?php }

    //Close the connection.
    mysqli_close($link);
?>

</body>
</html>


