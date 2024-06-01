<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    public function index(Request $request)
    {
        $key = base64_decode(env('KEY'));
        $nonce = base64_decode(env('Nonce'));
        // aditional data is hashed
        $additional_data = hash('sha256', env('AD'), true);
        
        // Validate the file 
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // Get the file

        $file = $request->file('file');
        $imagedata = file_get_contents($file->getRealPath());

        $encryptedData = $this->encryption($imagedata, $key, $nonce, $additional_data);
        $encryptedFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.jpeg.en';
        // automatic download of the encrypted image
        return response($encryptedData)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $encryptedFilename . '"');
    }
    private function encryption($imagedata, $key, $nonce, $additional_data)
    {
        // measeure the time taken to encrypt and decrypt the image
        $start = microtime(true); //start time for encryption
        $ciphertext = $this->encrypt($imagedata, $key, $nonce, $additional_data); //encrypt the image
        $end = microtime(true); //end time
        $time = $end - $start; //time taken
        // echo "Time taken to encrypt the image: $time seconds\n";//display the time taken        

        $dstart = microtime(true); //start time for decryption
        $dend = microtime(true); //end time
        $dtime = $dend - $dstart; //time taken
        // echo "Time taken to decrypt the image: $dtime seconds\n";//display the time taken

        // Encode the original and decrypted data as base64 to display them as images
        // $decrypted_image_base64 = base64_encode($decrypted);
        // echo '<html><body>';
        // echo '<h1>Encryption and Decryption Example</h1>';
        // // Display the encrypted data
        // echo '<h2>Encrypted Data:</h2>';
        // echo '<pre>' . base64_encode($ciphertext) . '</pre>';
        // // Display the decrypted image
        // echo '<h2>Decrypted Image:</h2>';
        // echo '<img src="data:image/jpeg;base64,' . $decrypted_image_base64 . '" alt="Decrypted Image"/>';
        // echo '</body></html>';

        return $ciphertext;
    }
    private function encrypt($imagedata, $key, $nonce, $additional_data)
    {
        // Validate input parameters
        if (!is_string($additional_data) || !is_string($nonce) || !is_string($key) || !is_string($imagedata)) {
            throw new \InvalidArgumentException('Invalid input parameters');
        }
        $ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
            $imagedata,
            $additional_data,
            $nonce,
            $key
        );
        return $ciphertext;
    }
}
