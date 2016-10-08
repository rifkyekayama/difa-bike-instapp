<?php

namespace App\Http\Requests\UserControl;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
			//
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'confirm_password' => 'required|same:password',
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Nama tidak boleh kosong!',
			'email.required' => 'Email tidak boleh kosong!',
			'email.email' => 'Kolom Email harus bertipe Email',
			'password.required' => 'Password tidak boleh kosong!',
			'confirm_password.required' => 'Confirm Password tidak boleh kosong!',
			'confirm_password.same' => 'Isian Konfirmasi Password tidak sama dengan kolom Password',
		];
	}
}
