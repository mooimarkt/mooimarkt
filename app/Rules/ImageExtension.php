<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageExtension implements Rule
{
    protected $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
    ];

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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));

        return in_array($ext, $this->allowedExtensions);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The file format is invalid. Supported formats are .jpg, .jpeg, .png.';
    }
}
