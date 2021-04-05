<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class TcKn implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $TC = $value;


        if (strlen($TC) == 11) {
            if (is_numeric($TC)) {
                $kayit = User::where('tcno', $TC)->exists();
                if ($kayit) {
                    return false;
                } else {
                    $TC_10 = ((($TC[0] + $TC[2] + $TC[4] + $TC[6] + $TC[8]) * 7) - ($TC[1] + $TC[3] + $TC[5] + $TC[7])) % 10;
                    if ($TC_10 == $TC[9]) {
                        $TC_11 = ($TC[0] + $TC[1] + $TC[2] + $TC[3] + $TC[4] + $TC[5] + $TC[6] + $TC[7] + $TC[8] + $TC[9]) % 10;
                        if ($TC_11 == $TC[10]) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'TC Kimlik Numarası hatalı veya daha önce kayıt olunmuş. Bir hata olduğunu düşünüyorsanız kutuphane@itk.k12.tr adresinden iletişime geçiniz.';
    }
}
