<?php

namespace App\Http\Requests;

use App\Traits\FormatResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    use FormatResponse;

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, $this->buildResponse($validator)));
    }

    protected function buildResponse($validator)
    {
        $response = $this->formatResponse('error', null, $validator->errors());
        return response($response, 200);
    }

    public function validForMe($type, $data)
    {
        $user = Auth::user();

        if ($user->$type == $data) {
            return true;
        } else {
            $response = $this->formatResponse('error', 'Access denied');
            return response($response, 200);
        }
    }
}