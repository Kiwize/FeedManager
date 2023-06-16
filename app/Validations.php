<?php

namespace App;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class Validations
{
    public static function feedSuggestMailValidation(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'feed_link' => 'url'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function feedSearchValidation(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'nameFilter' => 'regex:/^[a-bA-B0-9 ]+$/',
            'localeFilter' => 'max:2|string'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function feedFetchSearchValidation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nameFilter' => 'regex:/^[a-bA-B0-9 ]+$/',
            'localeFilter' => 'max:2|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function feedStoreValidation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:32',
            'link' => 'required|url',
            'author_logo' => 'string|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function feedDeleteIDValidation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'feedID' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function articlesFetchSearchValidation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'titleFilter' => 'max:32',
            'descriptionFilter' => 'max:255',
            'locale' => 'string|max:2',
            'from' => 'date_format:Y-m-d H:i:s',
            'to' => 'date_format:Y-m-d H:i:s',
            'resultsPerPage' => 'integer',
            'page' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    public static function articlesFetchValidation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'resultsPerPage' => 'integer',
            'localeFilter' => 'max:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }
}
