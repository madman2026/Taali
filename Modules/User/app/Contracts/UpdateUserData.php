<?php
namespace Modules\User\Contracts;

final class UpdateUserData
{
    public function __construct(
        public string $email,
        public string $name
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'] ?? '',
            name: $data['password'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name
        ];
    }
}
