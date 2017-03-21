<?php

    namespace OK;

    use PHP_Crypt\PHP_Crypt;

    class OKEncrypt {

        /**
         * TripleDES Encryption
         * @param  string $data   string to be encrypted
         * @param  string $secret encryption secret key
         * @return bool | string    false => on failure OR encrypted string => on success
         */
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

        /**
         * TripleDES Decryption
         * @param  string $data   string to be decrypted
         * @param  string $secret encryption secret key
         * @return bool | string    false => on failure OR encrypted string => on success
         */
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

        /**
         * Check if the current element is in array or equal to skip data.
         * For skip, pass is a key in case the data is an associative array or otherwise.
         * The array keys are used for associative array and value otherwise
         *
         * @param  bool $assoc test if the suppiled data is associative when its an array
         * @param  string $key   array element key
         * @param  string $value array element value
         * @param  array|string $skip  elements to skip if data is array. array key is used in case od associative array OR value otherwise
         *
         * @return bool
         */
       private static function in_array($assoc, $key, $value, $skip) {
           if ($assoc) {
               $value = $key;
           }
           return is_array($skip) ? in_array($value, $skip) : $value === $skip;
       }

       /**
        * Test for Associative Array
        *
        * @param  array  $arr
        *
        * @return bool
        */
       private static function is_associative(array $arr) {
           foreach ($arr as $key => $value) {
               if (is_string($key)) return true;
           }
           return false;
       }

       /**
        * Encrypt Data
        *
        * @param  string|array $data   string to be encrypted
        * @param  string $secret encryption secret key
        * @param  string|array $skip encryption secret key
        *
        * @return bool|string    false => on failure OR encrypted string => on success
        */
       public static function encrypt($data, $secret, $skip=[]) {

           if (is_array($data)) {
               $assoc = self::is_associative($data);
               foreach ($data as $key => $value) {  //var_dump($assoc, $key, $skip);die;

                   if (!self::in_array($assoc, $key, $value, $skip)) {
                       $value = self::encrypt($value, $secret);
                   }

                   $encrypt[$key] = $value;
               }
           }

           if (!isset($encrypt) && !$encrypt = self::encrypt3Des($data, $secret)) {
               $encrypt = $data;
           }

           return $encrypt;
       }

       /**
        * Decrypt Data
        *
        * @param  string|array $data   string to be encrypted
        * @param  string $secret encryption secret key
        * @param  string|array $skip encryption secret key
        *
        * @return bool|string    false => on failure OR encrypted string => on success
        */
       public static function decrypt($data, $secret, $skip=[]) {

           if (is_array($data)) {
               $assoc = self::is_associative($data);
               foreach ($data as $key => $value) {  //var_dump(!self::in_array($assoc, $key, $value, $skip));die;
                   if (!self::in_array($assoc, $key, $value, $skip)) {
                       $value = self::decrypt($value, $secret);
                   }
                   $decrypt[$key] = $value;
               }
           }

           if (!isset($decrypt) && !$decrypt = self::decrypt3Des($data, $secret)) {
               $decrypt = $data;
           }

           return $decrypt;
       }



    }
