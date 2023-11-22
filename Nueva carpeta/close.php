<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */
session_start();
session_destroy();
header('Location:/login');