<?php

namespace App\Filament\Teacher\Pages\Auth;

use Filament\Forms\Components\Select;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getCustomNameFormComponent(),
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCustomNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('filament-panels::pages/auth/register.form.name.label'))
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {

                if (!is_null($state)) {
                    if (strpos($state, ' ') === false) {
                        $set('fname', $state);
                        $set('lname', '');
                        // return;
                    } else {
                        $set('fname', explode(' ', $state)[0]);
                        $set('lname', explode(' ', $state)[1]);
                    }
                }
            })
            ->maxLength(255)
            ->autofocus();
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('fname')
            ->label('First Name')
            ->disabled()
            ->required();
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('lname')
            ->label('Last Name')
            ->disabled()
            ->required();
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('Phone')
            ->tel()
            ->required();
    }
}
