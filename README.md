## Symfony bundle for making translatable entities

### Prerequisites

1. Installation
2. Enable the Bundle
3. Entities
4. Repository
5. Form
6. Customize the behaviour for default translation and translation not found

### 1. Installation

**Using composer**

Run the composer to download the bundle:

``` bash
$ composer require janwebdev/translatable-entity-bundle
```

### 2. Enable the bundle

Check if bundle was enabled:

``` php
<?php
// ./config/bundles.php

return [
    // ...
    Janwebdev\TranslatableEntityBundle\TranslatableEntityBundle::class => ['all' => true],
];
```

### 3. Entities

``` php
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Article
{    
    /**
     * @ORM\OneToMany(targetEntity="ArticleTranslation", mappedBy="translatable", cascade={"persist"})
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }
}
```

``` php
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class ArticleTranslation
{    
    /**
     * 
     * @ORM\Column(name="locale", type="string", length=128)
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="translations")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $translatable;

    /**
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;
}
```
Then run doctrine:generate:entities and *remove the generated method addTranslation* (for Article in this example).
Now you can implement the correct interfaces.

``` php

<?php

namespace App\Entity;

use Janwebdev\TranslatableEntityBundle\Model\TranslatableWrapper;

class Article extends TranslatableWrapper
{    
    
}
```

TranslatableWrapper extends Translatable (that implements some methods of TranslatableInterface) and adds a magic method to wrap the methods of TranslatingInterface entity.

``` php
<?php

namespace App\Entity;

use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableInterface;

class ArtcileTranslation implements TranslatingInterface
{    
    
}
```

*Remember to modify the signature for ArticleTranslation::setTranslatable*

If you want "kill the magic", you can extend directly Janwebdev\TranslatableEntityBundle\Model\Translatable and create the needed wrapper methods by yourself.

### 4. Repository

``` php
<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function getArticleTranslatedQuery()
    {
        $qb = $this->createQueryBuilder('a')
            ->select(array('a', 'at'))
            ->leftJoin('a.translations', 'at');

        return $qb;
    }
}
```

### 5. Form

A possible form implementation

``` php
<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArtcileTranslationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('locale', 'hidden');
        $builder->add('name');
    }

    public function setDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'App\Entity\ArtcileTranslation',
        );
    }
}
```

``` php
<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('translations', 'collection', array(
            'type' => new ArtcileTranslation
            'by_reference' => false,
        ));
    }
}
```

### 6. Customize the behaviour for default translation and translation not found

If you want use as default translation, the first found translation even if is not a translation for current locale neither for default locale


 ``` php
 protected function acceptFirstTransaltionAsDefault()
 {
     return true;
 }
 ```

If you want a translation, only if was found one for the current locale


 ``` php
 protected function acceptDefaultLocaleTransaltionAsDefault()
 {
     return false;
 }
 ```

If you want manage by yourself the behaviour in case of translation not found

 ``` php
 protected function handleTranslationNotFound()
 {
     //your logic
 }
 ```

for example

  ``` php
 protected function handleTranslationNotFound()
 {
     $class = get_class($this) . 'Translation';
     if (class_exists($class)) {
         $this->translation = new $class;
     } else {
         $this->translation = null;
     }
 }
 ```

## Unit tests

``` bash
$ phpunit
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
