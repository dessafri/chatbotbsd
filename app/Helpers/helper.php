<?php

use Illuminate\Support\Facades\Crypt;

if (!function_exists('encryptData')) {
    /**
     * Encrypt the given data.
     *
     * @param mixed $data
     * @return string
     */
    function encryptData($data)
    {
        return Crypt::encrypt($data);
    }
}

if (!function_exists('decryptData')) {
    /**
     * Decrypt the given encrypted data.
     *
     * @param string $encryptedData
     * @return mixed
     */
    function decryptData($encryptedData)
    {
        try {
            return Crypt::decrypt($encryptedData);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle exception if needed
            return null;
        }
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        return 'Rp. ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('cleanCurrency')) {
    function cleanCurrency($value)
    {
        // Remove 'Rp.' and non-numeric characters, keeping only digits
        return preg_replace('/[^0-9]/', '', $value);
    }
}

