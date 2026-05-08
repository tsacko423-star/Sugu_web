<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAnnonceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'attributs' => 'nullable|array',
            'attributs.nom' => 'nullable|array',
            'attributs.nom.*' => 'string|max:255',
            'attributs.valeur' => 'nullable|array',
            'attributs.valeur.*' => 'string|max:255',
        ];
    }
}
