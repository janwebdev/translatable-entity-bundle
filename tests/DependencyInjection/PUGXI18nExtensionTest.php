<?php

namespace Janwebdev\TranslatableEntityBundle\Tests\DependencyInjection;

use Janwebdev\TranslatableEntityBundle\DependencyInjection\PUGXI18nExtension;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PUGXI18nExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $loader = new PUGXI18nExtension();
        $config = $this->getConfig();
        $loader->load(array($config), new ContainerBuilder());
    }    
    
    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getConfig()
    {
        $yaml = <<<EOF
classes:
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}
