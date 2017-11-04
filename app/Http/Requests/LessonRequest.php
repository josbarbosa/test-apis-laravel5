<?php namespace App\Http\Requests;

use App\Traits\ResponsableApi;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class LessonRequest extends FormRequest
{
    use ResponsableApi;
    /**
     * Force response json type when validation fails
     * @var bool
     */

    protected $forceJsonResponse = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (User::find(Auth::id())) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'body'  => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->respondFailedValidation($validator->errors()));
    }

}
