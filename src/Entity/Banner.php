<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BannerRepository::class)
 * @Vich\Uploadable()
 */
class Banner implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"}, inversedBy="banner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $banner_name;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="banner_image", fileNameProperty="banner_name")
     */
    private $banner_file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBannerName(): ?string
    {
        return $this->banner_name;
    }

    /**
     * @param string|null $banner_name
     * @return Banner
     */
    public function setBannerName(?string $banner_name): Banner
    {
        $this->banner_name = $banner_name;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getBannerFile(): ?File
    {
        return $this->banner_file;
    }

    /**
     * @param File|null $banner_file
     * @return Banner
     * @throws \Exception
     */
    public function setBannerFile(?File $banner_file): Banner
    {
        $this->banner_file = $banner_file;
        if ($this->banner_file instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}
