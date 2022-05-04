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
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->commonRequest->validateCommonBadRequest($validator);
    }
}
