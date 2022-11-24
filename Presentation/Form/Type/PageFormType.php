<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Form\Type;

use App\Entity\Cms\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Enum\PageStatusEnum;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphCoreInteractionInterface;

/**
 * Class PageFormType
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Form\Type
 */
class PageFormType extends AbstractType
{
    /** @var string */
    public const FORM_BUILDER_NAME = 'cmsCreatePageForm';

    /**
     * @param MorphCoreInteractionInterface $morphCoreInteraction
     * @param DomainInteractionInterface $domainInteraction
     */
    public function __construct(
        protected MorphCoreInteractionInterface $morphCoreInteraction,
        protected DomainInteractionInterface $domainInteraction
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formBuilder = $this->morphCoreInteraction->getDomainInteraction()->getFormBuilderService();
        $layouts = $this->domainInteraction->getThemeManagerService()->getAllLayouts();

        $formBuilder
            ->resetFields()
            ->add('name', TextType::class, 1, ['constraints' => new NotBlank()])
            ->add('url', TextType::class, 2)
            ->add(
                'layout',
                ChoiceType::class,
                3,
                ['choices' => $layouts, 'attr' => ['class' => 'form-control']]
            )
            ->add(
                'status',
                EnumType::class,
                4,
                ['class' => PageStatusEnum::class, 'attr' => ['class' => 'form-control']]
            )
            ->add('save', SubmitType::class, 5)
            ->build($builder, static::FORM_BUILDER_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
