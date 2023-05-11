<?php

namespace App\Command;

use App\Document\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'fixtures:load',
    description: 'Load fixtures into the DB',
)]
class FixturesLoader extends Command
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {
        parent::__construct('load:fixtures');
    }

    protected function configure()
    {
        $this->setDescription('Load fixtures into the DB');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $finder = new Finder();
        $finder->files()->in('./data');

        if (!$finder->hasResults()) {
            $output->writeln('No article has been found to be loaded into the DB');

            return Command::SUCCESS;
        }

        foreach ($finder as $file) {
            $domDocument = new \DOMDocument();
            $domDocument->loadXML($file->getContents());
            $id = $domDocument->documentElement->getAttribute('id');

            $article = new Article();
            $article->setId($id);
            $article->setXml($file->getContents());

            $this->articleRepository->save($article);
        }

        $output->writeln(sprintf('"%d" article(s) has been added to the DB.', $finder->count()));

        return Command::SUCCESS;
    }
}
