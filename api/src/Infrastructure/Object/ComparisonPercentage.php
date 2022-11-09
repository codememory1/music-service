<?php

namespace App\Infrastructure\Object;

final class ComparisonPercentage
{
    public function __construct(
        private readonly object $forCompare,
        private readonly object $withCompare,
        private readonly array $methodsForCompare
    ) {
    }

    public function compare(): ?int
    {
        $dataForCompare = $this->buildDataForCompare($this->forCompare, $this->methodsForCompare);
        $dataWithCompare = $this->buildDataForCompare($this->withCompare, $this->methodsForCompare);
        $compareCount = 0;

        foreach ($dataForCompare as $key => $value) {
            if ($value === $dataWithCompare[$key]) {
                ++$compareCount;
            }
        }

        return ($compareCount / count($dataWithCompare)) * 100;
    }

    private function buildDataForCompare(object $object, array $methodsForCompare): array
    {
        $data = [];

        foreach ($methodsForCompare as $methodName) {
            $data[$methodName] = $this->getValueMethod($methodName, $object);
        }

        return $data;
    }

    private function getValueMethod(string $name, object $object): mixed
    {
        if (method_exists($object, $name)) {
            return $object->$name();
        }

        return null;
    }
}