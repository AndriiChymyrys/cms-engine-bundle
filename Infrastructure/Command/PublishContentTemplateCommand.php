<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\DomainInteractionInterface;

#[AsCommand(
    name: 'cms:theme:content_template:publish',
    description: 'Publish WM CMS content templates which provided by themes'
)]
class PublishContentTemplateCommand extends Command
{
    public function __construct(protected DomainInteractionInterface $domainInteraction)
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->addArgument(
                'theme',
                InputArgument::OPTIONAL,
                'Specify theme name'
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $this->domainInteraction->getPublishService()->publish($input->getArgument('theme'));

        return Command::SUCCESS;
    }
}
