<?php

namespace App\Service;

use App\Helper\WordHelper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

class FileService
{
    protected ParameterBagInterface $parameterBag;

    /**
     * FileService constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function handle(): void
    {
        $file = $this->getFile();
        $newContent = $this->process($file->getContents());
        $this->saveFile($file->getFilename(), $newContent);
    }

    /**
     * @return SplFileInfo
     */
    protected function getFile(): SplFileInfo
    {
        return new SplFileInfo(
            $this->parameterBag->get('kernel.project_dir') . DIRECTORY_SEPARATOR
            . 'public' . DIRECTORY_SEPARATOR
            . 'file' . DIRECTORY_SEPARATOR
            . 'task1_file1.txt',
            '',
            ''
        );
    }

    /**
     * @param string $contents
     * @return string
     */
    protected function process(string $contents): string
    {
        return preg_replace_callback(
            '/\pL+/mu',
            static function ($matches): string {
                return WordHelper::changeLetterOrder($matches[0]);
            },
            $contents
        );
    }

    /**
     * @param string $name
     * @param string $contents
     */
    protected function saveFile(string $name, string $contents): void
    {
        $path = $this->parameterBag->get('kernel.project_dir') . DIRECTORY_SEPARATOR . 'var';
        $file = new Filesystem();
        $file->dumpFile($path . DIRECTORY_SEPARATOR . date('Y-m-d H:i:s') . $name, $contents);
    }

}