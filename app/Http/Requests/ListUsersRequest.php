<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DataProviderRule;
use Illuminate\Validation\Rule;

class ListUsersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'provider'   => ['string' , new DataProviderRule],
            'statusCode' => ['string' , Rule::in(['authorized', 'decline', 'refunded'])],
            'balanceMin' => ['numeric'] ,
            'balanceMax' => ['numeric'] ,
            'currency'   => ['alpha:ascii']  ,
        ];
    }

    public function messages()
    {
        return [
            'provide.string'    => "The :attribute must be either 'DataProviderX' or 'DataProviderY.",
            'statusCode.string' => "The :attribute must be either 'authorized' or 'decline' or 'refunded' .",
            'statusCode.in'     => "The :attribute must be either 'authorized' or 'decline' or 'refunded' .",
        ];
    }
}
