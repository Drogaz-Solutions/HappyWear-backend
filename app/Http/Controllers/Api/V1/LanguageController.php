<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LanguageController extends Controller
{
    public function getTranslation(Request $request)
    {

        $file = glob(resource_path('lang/' . $request->code . '.json'));
        $files = implode($file);
        $fileContent = file_get_contents($files);
        $json = json_decode($fileContent, true);

        $key = $request->key;

        $parts = explode('.', $key);
        $translation = $json;

        try {
            foreach ($parts as $part) {
                $translation = $translation[$part];
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Translation not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'lang' => $translation
        ], 200);
    }
}
