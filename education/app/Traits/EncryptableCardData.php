<?php
namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

// my own trait: to do data encryption and decryption while storing and retrieving from db
// will use it for model
trait EncryptableCardData
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable)) {
           $value = Crypt::decrypt($value);
        }

        // returning format [40055xxxxxxx0001]
        if($key == 'number'){
            $v = '';
            for ($i = 0; $i < strlen($value); $i++){
                if($i >= strlen($value) - 4){
                    $v .= $value[$i];
                }else{
                    if($i < 5){
                        $v .= $value[$i];
                    }else{
                        $v .= 'x';
                    }
                }
            }
            return $v;
        }

        // return format tes******
        if($key == 'holder'){
            $v = '';
            for ($i = 0; $i < strlen($value); $i++){
                if($i < 3){
                    $v .= $value[$i];
                }else{
                    $v .= '*';
                }
            }
            return $v;
        }

        // returning format *****
        if($key == 'cvv'){
            $v = '';
            for ($i = 0; $i < strlen($value); $i++){
                $v .= '*';
            }
            return $v;
        }

        // will return the decrypted value
        return $value;

    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = Crypt::encrypt($value);
        }

        // save the encrypted value
        return parent::setAttribute($key, $value);
    }
}
