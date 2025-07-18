<?php

declare(strict_types=1);

namespace Kreyu\Bundle\DataTableBundle\Filter;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterData
{
    public function __construct(
        private mixed $value = null,
        private ?Operator $operator = null,
    ) {
    }

    public static function fromArray(array $data = []): self
    {
        ($resolver = new OptionsResolver())
            ->setDefaults([
                'value' => '',
                'operator' => null,
            ])
            ->setAllowedTypes('operator', ['null', 'string', Operator::class])
            ->setNormalizer('operator', function (Options $options, mixed $value): ?Operator {
                return is_string($value) ? Operator::from($value) : $value;
            })
            ->setIgnoreUndefined()
        ;

        $data = $resolver->resolve($data);

        return new self(
            value: $data['value'],
            operator: $data['operator'],
        );
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(mixed $operator): void
    {
        $this->operator = $operator;
    }

    public function hasValue(): bool
    {
        return null !== $this->value && '' !== $this->value && [] !== $this->value;
    }
}
