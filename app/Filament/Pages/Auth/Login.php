<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    /**
     * Override form untuk support login dengan email atau username
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getLoginFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * Custom login field yang support email atau username
     */
    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email atau Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1])
            ->placeholder('Masukkan email atau username');
    }

    /**
     * Override credentials untuk support email atau username
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        // Cek apakah input adalah email atau username
        $loginType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $loginType => $login,
            'password' => $password,
        ];
    }

    /**
     * Custom error message
     */
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('Email/username atau password salah.'),
        ]);
    }
}
