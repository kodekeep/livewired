<?php

declare(strict_types=1);

/*
 * This file is part of kodekeep/livewired.
 *
 * (c) KodeKeep <hello@kodekeep.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KodeKeep\Livewired\Components\Passport;

use KodeKeep\Livewired\Components\Component;
use KodeKeep\Livewired\Components\Concerns\InteractsWithUser;
use Laravel\Passport\Token;

class UpdatePersonalAccessToken extends Component
{
    use InteractsWithUser;

    public $tokenId;

    public ?string $name = null;

    protected $listeners = [
        'editPersonalAccessToken' => 'editPersonalAccessToken',
    ];

    public function editPersonalAccessToken($tokenId): void
    {
        $this->tokenId = $tokenId;

        $this->fill($this->personalAccessToken);
    }

    public function updatePersonalAccessToken(): void
    {
        $this->validate(['name' => ['required', 'max:255']]);

        $this->personalAccessToken->update(['name' => $this->name]);

        $this->emit('refreshPersonalAccessTokens');
    }

    public function getPersonalAccessTokenProperty(): ?Token
    {
        return $this->user->tokens()->find($this->tokenId);
    }
}
