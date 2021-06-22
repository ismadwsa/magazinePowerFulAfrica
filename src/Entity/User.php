<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=PubliciteHeader::class, mappedBy="user")
     */
    private $publicitePrincipale;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $article;

 

    public function __construct()
    {
        $this->publicitePrincipale = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|PubliciteHeader[]
     */
    public function getPublicitePrincipale(): Collection
    {
        return $this->publicitePrincipale;
    }

    public function addPublicitePrincipale(PubliciteHeader $publicitePrincipale): self
    {
        if (!$this->publicitePrincipale->contains($publicitePrincipale)) {
            $this->publicitePrincipale[] = $publicitePrincipale;
            $publicitePrincipale->setUser($this);
        }

        return $this;
    }

    public function removePublicitePrincipale(PubliciteHeader $publicitePrincipale): self
    {
        if ($this->publicitePrincipale->removeElement($publicitePrincipale)) {
            // set the owning side to null (unless already changed)
            if ($publicitePrincipale->getUser() === $this) {
                $publicitePrincipale->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    /**
     * @return Collection|AncienneMagazine[]
     */
    public function getAncienneMagazine(): Collection
    {
        return $this->ancienneMagazines;
    }

    public function addAncienneMagazine(AncienMagazine $ancienneMagazine): self
    {
        if (!$this->ancienneMagazines->contains($ancienneMagazine)) {
            $this->ancienneMagazines[] = $ancienneMagazine;
            $ancienneMagazine->setUser($this);
        }

        return $this;
    }

    public function removeAncienneMagazine(ancienMagazine $ancienneMagazine): self
    {
        if ($this->articles->removeElement($ancienneMagazine)) {
            // set the owning side to null (unless already changed)
            if ($ancienneMagazine->getUser() === $this) {
                $ancienneMagazine->setUser(null);
            }
        }

        return $this;
    }

 

}
