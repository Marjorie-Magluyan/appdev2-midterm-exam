<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class ProductAccessMiddleware
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    
    public function handle(Request $request, Closure $next){
        $validToken = env('API_TOKEN');

        $token = $request->header('Authorization');

        if(!$token){
            return response()->json(['Error' => 'Token is missing'], 401);
        }

        if($token !== $validToken){
            return response()->json(['Error' => 'Token is invalid'], 401);
        }

        return $next($request);
    }
   

    public function store(Request $request)
    {
        return response()->json(['message' => 'Product created successfully.']);
    }

    public function update(Request $request, string $id)
    {
        return response()->json(['message' => 'Product with ID: ' . $id . ' updated successfully']);
    }

    public function destroy(string $id)
    {
        return response()->json(['message' => 'Product with ID: ' . $id . ' deleted successfully']);
    }

    public function uploadImageLocal(Request $request){
        if($request->hasFile('image')){
            Storage::disk('upload.local')->put('/', $request->file('image'));
                return "Image successfully stored in local disk driver.";
        }
            return "No image uploaded.";
    }

    public function uploadImagePublic(Request $request){
        if($request->hasFile('image')){
            Storage::disk('upload.public')->put('/', $request->file('image'));
                return "Image successfully stored in public disk driver.";
        }
            return "No image uploaded.";
    }


}

