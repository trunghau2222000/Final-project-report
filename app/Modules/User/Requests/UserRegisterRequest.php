<?php

namespace App\Modules\User\Requests;

use App\Helpers\CommonRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    private $commonRequest;

    public function __construct(CommonRequest $commonRequest)
    {
        $this->commonRequest = $commonRequest;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:20|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|confirmed|max:15',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->commonRequest->validateCommonBadRequest($validator);
    }

    public function messages()
    {
        return [
            'username.required'  => 'Username can not be empty',
            'username.string'    => 'Username must be of type string',
            'username.max'       => 'The maximum length of the username is 20',
            'username.unique'    => 'User already exists',


            'email.required'     => 'Email can not be empty',
            'email.email'        => 'Invalid email',
            'email.unique'       => 'Email already exists',

            'password.required'  => 'Password can not be empty',
            'password.string'    => 'Password must be of type string',
            'password.confirmed' => 'Confirmation password is not correct',
            'password.max'       => 'The maximum length of the password is 15',
        ];
    }
}
