<?php

namespace App\Http\Controllers;

use App\Mail\FeedAddRequest;
use App\Validations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validator = Validations::feedSuggestMailValidation($request);
        if ($validator->getStatusCode() != Response::HTTP_OK) {
            return $validator;
        }

        $feedData = [
            'user_uuid' => $request->user_uuid,
            'feed_link' => $request->feed_link
        ];

        Mail::to('recipient@example.com')->send(new FeedAddRequest($feedData));
        return response()->json(['response' => 'Mail send successfully']);
    }
}
