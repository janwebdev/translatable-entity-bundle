<?php

namespace Janwebdev\TranslatableEntityBundle\Model;

abstract class TranslatableWrapper extends Translatable
{
    /** @var array<string, \ReflectionClass> */
    private static array $reflectionCache = [];

    /**
     * @param string $method
     * @return mixed
     * @throws \ReflectionException
     */
    public function __get(string $method): mixed
    {
        $translation = $this->getTranslation();
        $reflectedTranslation = $this->getReflectionClass($translation);

        $getters = $this->getGetters($method);
        foreach ($getters as $getter) {
            if ($reflectedTranslation->hasMethod($getter)) {
                $reflectedMethod = $reflectedTranslation->getMethod($getter);
                if ($reflectedMethod->isPublic()) {
                    return $reflectedMethod->invoke($translation);
                }
            }
        }

        throw new \RuntimeException(sprintf('The method "%s" does not exist', $method));
    }

    /**
     * @param string $method
     * @param array<int, mixed> $args
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call(string $method, array $args): mixed
    {
        return $this->__get($method);
    }

    /**
     * @param string $method
     * @return array<int, string>
     */
    protected function getGetters(string $method): array
    {
        return [
            $method,
            'get' . ucfirst($method)
        ];
    }

    /**
     * Get cached ReflectionClass instance
     */
    private function getReflectionClass(object $object): \ReflectionClass
    {
        $className = $object::class;
        
        if (!isset(self::$reflectionCache[$className])) {
            self::$reflectionCache[$className] = new \ReflectionClass($object);
        }
        
        return self::$reflectionCache[$className];
    }
}
