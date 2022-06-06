<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\DependencyInjection;

use Janwebdev\TranslatableEntityBundle\DependencyInjection\Configuration;
use Janwebdev\TranslatableEntityBundle\DependencyInjection\TranslatableEntityExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TranslatableEntityExtensionTest extends TestCase
{
    public function testLoad(): void
    {
	    $loader = new TranslatableEntityExtension();
	    $container = new ContainerBuilder();
	    $config = $this->getConfig();
	    $loader->load([$config], $container);

	    $loadedConfiguration = $loader->getConfiguration($config, $container);

	    $this->assertInstanceOf(Configuration::class, $loadedConfiguration);
    }
    
    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getConfig(): array
    {
        $yaml = <<<EOF
classes:
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
