<?php

namespace App\Controller;

use App\Entity\Images;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController.
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class BaseController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected EntityManagerInterface $em;

    /**
     * BaseController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param object $object
     * @return bool
     */
    public function save(object $object): bool
    {
        try {
            if (!$object->getId()) {
                $this->em->persist($object);
            }
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param object $object
     * @return boolean
     */
    public function remove(object $object): bool
    {
        try {
            if ($object) {
                $this->em->remove($object);
            }
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Upload Files.
     *
     * @param array $files
     * @param object $object
     * @return object
     */
    public function uploadFiles(array $files, object $object): object
    {
        foreach ($files as $file) {
            $filename = sprintf('%s.%s', Uuid::v4(), $file->guessExtension());
            $file->move($this->getParameter('upload_directory'), $filename);

            $image = new Images();
            $image->setName($filename);
            $object->addImage($image);
        }
        return $object;
    }
}