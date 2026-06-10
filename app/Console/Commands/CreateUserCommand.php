<?php

namespace App\Console\Commands;

use App\Models\User;
use Hash;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Throwable;

#[Signature('user:create {name} {email}')]
#[Description('Cria um usuário')]
class CreateUserCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userName = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->secret('Digite a senha');

        try {
            Validator::validate([
                    'name' => $userName,
                    'password' => $password,
                    'email' => $email,
                ],
                [
                    'name' => [
                        'required',
                        'string',
                        'min:2',
                        'max:255',
                    ],
                    'email' => [
                        'required',
                        'email',
                        'unique:users,email'
                    ],
                    'password' => Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised(),
                ]);

            $user = (new User)->create([
                'name' => $userName,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            $this->info("Usuário criado com sucesso {$user->id}");
        } catch (Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}

