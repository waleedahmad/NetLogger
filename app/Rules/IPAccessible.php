<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IPAccessible implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isReachable($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'IP address not reachable.';
    }

    private function isReachable($ip) {
        exec("/bin/ping -c 1 $ip", $outcome, $status);
        return $status === 0;
    }
}
