<?php

namespace App\Exceptions;

use Exception;

class NewsNotBelongsToUser extends Exception
{
    public function render()
    {
    	return ['errors' => 'News Not Belongs to User'];
    }
}
