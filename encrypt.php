<?php

    namespace OK;

    use PHP_Crypt\PHP_Crypt;

    class OKEncrypt {

        public static function encrypt($data, $secret) {
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

        public static function decrypt($data, $secret) {
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

    }
