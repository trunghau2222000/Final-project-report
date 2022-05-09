<?php

namespace App\Modules\User\Requests;

use App\Helpers\CommonRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class UserLoginRequest extends FormRequest
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
            'username' => 'required|string|max:15',
            'password' => 'required|string|max:15',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->commonRequest->validateCommonBadRequest($validator);
    }

    public function messages()
    {
        return [
            'username.required' => 'Username can not be empty',
            'username.string'   => 'Username must be of type string',
            'username.max'      => 'The maximum length of the username is 15',

            'password.required' => 'Password can not be empty',
            'password.string'   => 'Password must be of type string',
            'password.max'      => 'The maximum length of the password is 15',
        ];
    }
}
