<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AvatarRepository::class)
 * @Vich\Uploadable()
 */
class Avatar implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"}, inversedBy="avatar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $avatar_name;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="avatar_image", fileNameProperty="avatar_name")
     */
    private $avatar_file;

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
    public function getAvatarName(): ?string
    {
        return $this->avatar_name;
    }

    /**
     * @param string|null $avatar_name
     * @return Avatar
     */
    public function setAvatarName(?string $avatar_name): Avatar
    {
        $this->avatar_name = $avatar_name;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatar_file;
    }

    /**
     * @param File|null $avatar_file
     * @return Avatar
     * @throws \Exception
     */
    public function setAvatarFile(?File $avatar_file): Avatar
    {
        $this->avatar_file = $avatar_file;
        if ($this->avatar_file instanceof UploadedFile) {
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
