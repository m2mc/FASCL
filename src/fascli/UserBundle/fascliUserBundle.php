<?php

// src/fascli/UserBundle/fascliUserBundle.php

namespace fascli\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class fascliUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
