<?php

namespace App\Http\Requests;

use App\Models\ContactMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prenom' => ['required', 'string', 'max:100'],
            'nom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'commune' => ['nullable', 'string', 'max:100'],
            'prestation' => ['nullable', Rule::in(array_keys(ContactMessage::PRESTATIONS))],
            'message' => ['required', 'string', 'max:5000'],
            'audio' => ['nullable', 'file', 'mimetypes:audio/webm,audio/ogg,audio/mpeg,audio/wav,audio/mp4,video/webm', 'max:10240'],
            'audio_duration_seconds' => ['nullable', 'integer', 'min:0', 'max:180'],
            // Honeypot anti-spam : ce champ est caché en CSS, un vrai visiteur ne le remplit jamais.
            'website' => ['prohibited'],
        ];
    }

    public function attributes(): array
    {
        return [
            'prenom' => 'prénom',
            'nom' => 'nom',
            'telephone' => 'téléphone',
            'message' => 'projet',
        ];
    }
}
