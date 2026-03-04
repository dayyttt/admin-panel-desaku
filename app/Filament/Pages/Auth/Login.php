<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use MarcoGermani87\FilamentCaptcha\Forms\Components\CaptchaField;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getCaptchaFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getCaptchaFormComponent(): Component
    {
        return CaptchaField::make('captcha')
            ->label('Kode Keamanan')
            ->required()
            ->validationMessages([
                'captcha' => 'Kode keamanan tidak valid.',
                'required' => 'Kode keamanan wajib diisi.',
            ])
            ->helperText('Masukkan kode yang terlihat pada gambar');
    }
}