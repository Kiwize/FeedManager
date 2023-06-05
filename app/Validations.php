<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Validations
{

    public static function validateAddFeed(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20',
            'link' => 'required|url'
        ]);

        return $validator->fails();
    }

    public static function validateDeleteFeed(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'feedID' => 'required|integer'
        ]);

        return $validator->fails();
    }

    public static function validateGetLocale(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'articlesPerPage' => 'integer',
            'page' => 'integer'
        ]);

        return $validator->fails();
    }

    public static function validateIndex(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'articlesPerPage' => 'integer',
            'page' => 'integer'
        ]);

        return $validator->fails();
    }

    public static function validateStore(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'titleFilter' => 'max:32',
            'descriptionFilter' => 'max:255',
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',
            'articlesPerPage' => 'required|integer',
            'page' => 'integer'
        ]);

        return $validator->fails();
    }

    public static function validateGetArticleList(Request $request): bool
    {
        $validator = Validator::make($request->all(), [
            'search' => 'max:255|alpha'
        ]);

        return $validator->fails();
    }
}
