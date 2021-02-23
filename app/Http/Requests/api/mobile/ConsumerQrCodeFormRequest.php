<?php


namespace App\Http\Requests\api\mobile;


use App\Http\Requests\api\BaseApiFormRequest;

class ConsumerQrCodeFormRequest extends BaseApiFormRequest
{
    protected $forceJsonResponse = true;

    /**
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
            'qr_code_hash' => 'required|string',
            'consumer_id'  => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'qr_code_hash.required' => 'ERROR_QR_CODE_HASH_IS_REQUIRED',
            'qr_code_hash.string'   => 'ERROR_QR_CODE_HASH_MUST_BE_STRING',

            'consumer_id.required' => 'ERROR_CONSUMER_ID_IS_REQUIRED',
            'consumer_id.numeric'  => 'ERROR_CONSUMER_ID_MUST_BE_NUMERIC',
        ];
    }
}