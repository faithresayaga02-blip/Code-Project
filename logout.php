<?php
session_start();

session_abort();
session_destroy();
session_unset();

header('location: index.php');