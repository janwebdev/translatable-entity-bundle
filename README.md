## Symfony Bundle for Making Translatable Entities

[![Unit Tests](https://github.com/janwebdev/translatable-entity-bundle/actions/workflows/run-tests.yml/badge.svg)](https://github.com/janwebdev/translatable-entity-bundle/actions/workflows/run-tests.yml)
[![Latest Stable Version](https://poser.pugx.org/janwebdev/translatable-entity-bundle/v)](//packagist.org/packages/janwebdev/translatable-entity-bundle)
[![Total Downloads](https://poser.pugx.org/janwebdev/translatable-entity-bundle/downloads)](//packagist.org/packages/janwebdev/translatable-entity-bundle)
[![License](https://poser.pugx.org/janwebdev/translatable-entity-bundle/license)](//packagist.org/packages/janwebdev/translatable-entity-bundle)

A modern Symfony bundle for creating translatable entities with support for **PHP 8.2+** and **Symfony 6.4/7.x**.

### Features

- 🚀 **Modern PHP 8.2+** - Full type safety with typed properties and return types
- ⚡ **Performance Optimized** - Reflection caching and efficient translation lookups
- 🎯 **Symfony 7.x Ready** - Uses modern Symfony attributes and autowiring
- 🔄 **Flexible Fallback System** - Configurable translation fallback mechanisms
- 📦 **Easy Integration** - Simple setup with Doctrine ORM

---

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Enable the Bundle](#enable-the-bundle)
4. [Creating Translatable Entities](#creating-translatable-entities)
5. [Usage in Controllers](#usage-in-controllers)
6. [Repository Examples](#repository-examples)
7. [Form Integration](#form-integration)
8. [Customizing Translation Behavior](#customizing-translation-behavior)
9. [Testing](#testing)

---

## Requirements

- **PHP**: 8.2 or higher
- **Symfony**: 6.4 or higher
- **Doctrine ORM**: 2.19 or 3.x

---

## Installation

Install the bundle via Composer:

```bash
composer require janwebdev/translatable-entity-bundle
```

---

## Enable the Bundle

The bundle should be automatically registered. Verify in `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...
    Janwebdev\TranslatableEntityBundle\TranslatableEntityBundle::class => ['all' => true],
];
```

---

## Creating Translatable Entities

### Step 1: Create the Main Entity

```php
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Janwebdev\TranslatableEntityBundle\Model\TranslatableWrapper;

#[ORM\Entity]
#[ORM\Table(name: 'article')]
class Article extends TranslatableWrapper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var Collection<int, ArticleTranslation>
     */
    #[ORM\OneToMany(
        targetEntity: ArticleTranslation::class,
        mappedBy: 'translatable',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ArticleTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(ArticleTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setTranslatable($this);
        }

        return $this;
    }

    public function removeTranslation(ArticleTranslation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            if ($translation->getTranslatable() === $this) {
                $translation->setTranslatable(null);
            }
        }

        return $this;
    }
}
```

### Step 2: Create the Translation Entity

```php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Janwebdev\TranslatableEntityBundle\Model\TranslatingInterface;

#[ORM\Entity]
#[ORM\Table(name: 'article_translation')]
#[ORM\UniqueConstraint(name: 'article_locale_unique', columns: ['article_id', 'locale'])]
class ArticleTranslation implements TranslatingInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 10)]
    private string $locale;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Article $translatable = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setTranslatable(Article $translatable): void
    {
        $this->translatable = $translatable;
    }

    public function getTranslatable(): ?Article
    {
        return $this->translatable;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
```

---

## Usage in Controllers

```php
<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'article_show')]
    public function show(Article $article): Response
    {
        // The bundle automatically sets the locale from the request
        // Access translated properties through magic methods
        $title = $article->title;        // or $article->getTitle()
        $content = $article->content;    // or $article->getContent()

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'title' => $title,
            'content' => $content,
        ]);
    }
}
```

---

## Repository Examples

Always join translations for better performance:

```php
<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Get all articles with translations joined
     */
    public function findAllWithTranslations(): array
    {
        return $this->createQueryBuilderWithTranslations()
            ->getQuery()
            ->getResult();
    }

    /**
     * Find one article by ID with translations
     */
    public function findOneWithTranslations(int $id): ?Article
    {
        return $this->createQueryBuilderWithTranslations()
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Create query builder with translations joined
     */
    private function createQueryBuilderWithTranslations(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.translations', 'at')
            ->addSelect('at');
    }
}
```

---

## Form Integration

### Translation Form Type

```php
<?php

namespace App\Form;

use App\Entity\ArticleTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locale', HiddenType::class)
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleTranslation::class,
        ]);
    }
}
```

### Main Entity Form Type

```php
<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', CollectionType::class, [
                'entry_type' => ArticleTranslationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Translations',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
```

---

## Customizing Translation Behavior

Override these methods in your translatable entity to customize behavior:

```php
<?php

namespace App\Entity;

use Janwebdev\TranslatableEntityBundle\Model\TranslatableWrapper;

class Article extends TranslatableWrapper
{
    // ... your code ...

    /**
     * Return true to use the first available translation as fallback
     * when translation for current locale is not found
     */
    protected function acceptFirstTranslationAsDefault(): bool
    {
        return true; // Default: false
    }

    /**
     * Return false to NOT use default locale translation as fallback
     */
    protected function acceptDefaultLocaleTranslationAsDefault(): bool
    {
        return true; // Default: true
    }

    /**
     * Handle the case when no translation is found
     * Override to provide custom behavior (e.g., return empty translation)
     */
    protected function handleTranslationNotFound(): never
    {
        // Create an empty translation instead of throwing exception
        $class = ArticleTranslation::class;
        $this->translation = new $class();
        $this->translation->setLocale($this->locale->getLocale());

        return $this->translation;
    }
}
```

### Fallback Priority

The bundle uses this fallback mechanism:

1. **Exact match** - Translation for current locale
2. **Default locale** - Translation for default locale (if `acceptDefaultLocaleTranslationAsDefault()` returns true)
3. **First translation** - First available translation (if `acceptFirstTranslationAsDefault()` returns true)
4. **Handle not found** - Calls `handleTranslationNotFound()` (throws exception by default)

---

## Testing

Run the test suite:

```bash
composer install
vendor/bin/phpunit
```

Run code quality checks:

```bash
vendor/bin/grumphp run
```

Run static analysis:

```bash
vendor/bin/phpstan analyse
```

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on recent changes.

---

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

---

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## Credits

- [Jan Rogozinsky](https://github.com/janwebdev)
- [All Contributors](../../contributors)
