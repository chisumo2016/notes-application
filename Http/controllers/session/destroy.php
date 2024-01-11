<?php

/*log the user out*/

use Core\Authenticator;

//logout();

(new Authenticator)->logout();

header('location: /');
exit();