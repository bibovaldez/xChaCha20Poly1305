<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DecryptionController extends Controller
{
    public function index(Request $request)
    {
        $key = base64_decode(env('KEY'));
        $nonce = base64_decode(env('NONCE'));
        // Additional data is hashed
        $additional_data = hash('sha256', env('AD'), true);

        // Validate the file input
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $ciphertext = file_get_contents($file->getRealPath());

        $decryptedData = $this->decrypt($ciphertext, $key, $nonce, $additional_data);

        if ($decryptedData === false) {
            return response('Decryption failed.', 500);
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $decryptedFilename = $originalFilename . '.jpg'; // Adjust extension as needed

        // Automatic download of the decrypted image
        return response($decryptedData)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $decryptedFilename . '"');
    }

    private function decrypt($ciphertext, $key, $nonce, $additional_data)
    {
        // Validate input parameters
        if (!is_string($ciphertext) || !is_string($additional_data) || !is_string($nonce) || !is_string($key)) {
            throw new \InvalidArgumentException('Invalid input parameters');
        }

        $message = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
            $ciphertext,
            $additional_data,
            $nonce,
            $key
        );

        return $message !== false ? $message : null; // Return null if decryption fails
    }
}
