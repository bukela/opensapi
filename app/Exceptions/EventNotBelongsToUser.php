<?php

namespace App\Exceptions;

use Exception;

class EventNotBelongsToUser extends Exception
{
    public function render()
    {
    	return ['errors' => 'Event Not Belongs to User'];
    }
}
