<?php


namespace Janwebdev\TranslatableEntityBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder('janwebdev_translatable_entity');

		$treeBuilder->getRootNode()
			->children()
				->arrayNode('classes')
					->addDefaultsIfNotSet()
					->canBeUnset()
				->end()
			->end();

		return $treeBuilder;
	}
}
