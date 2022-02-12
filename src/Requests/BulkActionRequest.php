<?php

namespace Adminro\Requests;

use Adminro\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkActionRequest extends FormRequest
{
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
            'bulk_action' => ['required', Rule::in(Constants::BULK_ACTION_VALUES)],
            'ids' => ['required'],
        ];
    }
}
