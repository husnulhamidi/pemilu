<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class IsValidPassword implements Rule
{
    /**
     * Determine if the Length Validation Rule passes.
     *
     * @var boolean
     */
    public $lengthPasses = true;

    /**
     * Determine if the Uppercase Validation Rule passes.
     *
     * @var boolean
     */
    public $uppercasePasses = true;

    /**
     * Determine if the Numeric Validation Rule passes.
     *
     * @var boolean
     */
    public $numericPasses = true;

    /**
     * Determine if the Special Character Validation Rule passes.
     *
     * @var boolean
     */
    public $specialCharacterPasses = true;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->uppercasePasses = (Str::lower($value) !== $value);
        $this->numericPasses = ((bool)preg_match('/[0-9]/', $value));
        //$this->specialCharacterPasses = ((bool)preg_match('/[^A-Za-z0-9]/', $value));
        $this->specialCharacterPasses = preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $value);

        return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses && $this->specialCharacterPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->lengthPasses==false){
            return "Panjang minimal 8 karakter";
        }else if ($this->uppercasePasses== false){
            return "Harus mengandung huruf kapital";
        }
        else if ($this->numericPasses== false){
            return "Harus mengandung angka";
        }else if ($this->specialCharacterPasses){
            return "Harus mengandung spesial karakter";
        }else{
            return "testing" ;
        }
    }
}