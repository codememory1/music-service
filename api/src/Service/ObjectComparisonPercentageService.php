<?php

namespace App\Service;

class ObjectComparisonPercentageService
{
    private object $forCompare;
    private object $withCompare;
    private array $methodsForCompare;

    public function __construct(object $forCompare, object $withCompare, array $methodsForCompare)
    {
        $this->forCompare = $forCompare;
        $this->withCompare = $withCompare;
        $this->methodsForCompare = $methodsForCompare;
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