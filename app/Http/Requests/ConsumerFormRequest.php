<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumerFormRequest extends FormRequest
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
            'account_id'                           => 'nullable|numeric|unique:consumers,account_id,' . $this->id,
            'firstname'                            => 'required_without:type|string',
            'lastname'                             => 'required_without:type|string',
            'birthday'                             => 'required_without:type|string',
            'location_group_id'                    => 'required_without:type|numeric',
            'imageurl'                             => 'nullable|string',
            'balance_limit'                        => 'required_without:type|numeric',
            'subsidization.subsidization_document' => 'nullable|file',
            'subsidization.subsidization_rule_id'  => 'nullable|numeric',
            'subsidization.subsidization_start'    => 'required_with:subsidization.subsidization_rule_id|nullable|date',
            'subsidization.subsidization_end'      => 'required_with:subsidization.subsidization_rule_id|nullable|date|after_or_equal:subsidization.subsidization_start',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'location_group_id'                    => 'Location group',
            'firstname'                            => 'First name',
            'lastname'                             => 'Last name',
            'subsidization.subsidization_rule_id'  => 'Subsidization Rule',
            'subsidization.subsidization_document' => 'Subsidization Document',
            'subsidization.subsidization_start'    => 'Subsidization Start Date',
            'subsidization.subsidization_end'      => 'Subsidization End Date',
        ];
    }
}
