<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\CMS\Models\Category;

class CategoryRequest extends FormRequest
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

    public  function rules()
    {
        return !$this->id ? $this->createRule() : $this->updateRule();
    }

    public   function createRule()
    {
        return [
            'name' => ['required','string', sprintf('unique_translation:%s,name', Category::getTableName())],
            'description'=>['nullable', 'string','max:256'],
            'featured_image' => ['string','url']
        ];
    }
    public  function updateRule()
    {
        return [
            'name' => ['string',sprintf('unique_translation:%s,name,%s', Category::getTableName(), $this->id)],
            'description'=>['nullable', 'string','max:256'],
            'featured_image' => ['string','url']
        ];
    }
}
