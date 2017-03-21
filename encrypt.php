<?php

    namespace OK;

    use PHP_Crypt\PHP_Crypt;

    class OKEncrypt {

        public static function encrypt3Des($data, $secret) {
            //Generate a key from a hash
            $key = md5(utf8_encode($secret), true);

            //Take first 8 bytes of $key and append them to the end of $key.
            $key .= substr($key, 0, 8);

            //Pad for PKCS7
            $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
            $len = strlen($data);
            $pad = $blockSize - ($len % $blockSize);
            $data = $data.str_repeat(chr($pad), $pad);

            //Encrypt data
            $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');

            //return $this->strToHex($encData);

            return base64_encode($encData);
        }

        public static function decrypt3Des($data, $secret) {
           //Generate a key from a hash
           $key = md5(utf8_encode($secret), true);

           //Take first 8 bytes of $key and append them to the end of $key.
           $key .= substr($key, 0, 8);

           $data = base64_decode($data);

           $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');

           $block = mcrypt_get_block_size('tripledes', 'ecb');
           $len = strlen($data);
           $pad = ord($data[$len-1]);

           return substr($data, 0, strlen($data) - $pad);
       }

       public static function encrypt_array($data, $enc_key, $skip=null) {
           $encrypted = [];

           if (is_array($data)) {
               foreach ($data as $key => $value) {
                   if (in_array($key, $skip)) continue;
                   OKEncrypt::encrypt_array($value);
               }
           }

           if (!$encrypt = OKEncrypt::encrpt3Des($value, $enc_key)) {
               $encrypt = $value;
           }
           return $encrypt;
       }

       public static function decrypt_array($data, $enc_key, $skip=null) {
           $decrypted = [];

           if (is_array($data)) {
               foreach ($data as $key => $value) {
                   if (in_array($key, $skip)) continue;
                   OKEncrypt::decrypt_array($value);
               }
           }

           if (!$decrypt = OKEncrypt::decrpt3Des($data, $enc_key)) {
               $decrypt = $data;
           }

           return $decrypt;
       }


    }
