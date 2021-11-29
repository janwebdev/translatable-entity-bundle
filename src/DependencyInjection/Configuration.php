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
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('sellit_translatable');

		$rootNode
			->children()
				->arrayNode('classes')
					->addDefaultsIfNotSet()
					->canBeUnset()
				->end()
			->end();

		return $treeBuilder;
	}
}
