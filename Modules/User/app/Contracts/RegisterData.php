<?php
namespace Modules\User\Contracts;

final class RegisterData
{
    public function __construct(
        public string $email,
        public string $name,
        public string $password,
        public bool $remember = false
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'] ?? '',
            name: $data['name'] ?? '',
            password: $data['password'] ?? '',
            remember: isset($data['remember']) && filter_var($data['remember'], FILTER_VALIDATE_BOOLEAN)
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'password' => $this->password,
            'remember' => $this->remember,
        ];
    }
}
