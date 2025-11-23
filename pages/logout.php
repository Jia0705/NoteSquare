<?php
    // remove user session
    unset( $_SESSION['user'] );
    unset( $_SESSION['success'] );
    unset( $_SESSION['error'] );
    
    // redirect the user back to home page
    redirect( "/" );
