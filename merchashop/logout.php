<?php

/**
 * @author Dani Agullo Heredia
 * @version 1.0
 */

//if(token create)

unset($token);
unset($token);
session_start();
session_destroy();
header('Location:/index');