<?php


namespace Janwebdev\TranslatableEntityBundle;

use Janwebdev\TranslatableEntityBundle\DependencyInjection\TranslatableEntityExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TranslatableEntityBundle extends Bundle
{
	public function getContainerExtension()
	{
		return new TranslatableEntityExtension();
	}
}
