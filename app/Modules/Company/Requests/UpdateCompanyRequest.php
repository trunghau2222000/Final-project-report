<?php

namespace App\Modules\Company\Requests;

use App\Helpers\CommonRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name'    => 'required|string|max:50',
            'address' => 'required|string|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->commonRequest->validateCommonBadRequest($validator);
    }

    public function messages()
    {
        return [
            'name.required'  => 'Name can not be empty',
            'name.string'    => 'Name must be of type string',
            'name.max'       => 'The maximum length of the name is 50',

            'address.required'  => 'Address can not be empty',
            'address.string'    => 'Address must be of type string',
            'address.max'       => 'The maximum length of the address is 225',
        ];
    }
}
