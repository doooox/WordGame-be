<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WordRepository::class)]
class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z]+$/",
        message: "Word must be a valid English word!"
    )]
    private ?string $word = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }
    public function getLetterScore()
    {
        $numberOfLetters = str_split((string)$this->word);
        $uniqueLetters = array_unique($numberOfLetters);
        $lettersScore = count($uniqueLetters);
        return $lettersScore;
    }
    public function isPalindrom()
    {
        if ($this->word == strrev($this->word)) {
            return true;
        }
        return false;
    }
    public function isAlmostPalindrom()
    {
        if (strlen($this->word) > 2) {
            for ($i = 0; $i <= strlen($this->word); $i++) {
                $testWord = substr($this->word, 0, $i) . substr($this->word, $i + 1);
                if ($testWord === strrev($testWord)) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    public function getScore(): int
    {
        $score = 0;

        $score = $this->getLetterScore();
        $isPalindrome = $this->isPalindrom();
        $isAlmostPalindrome = $this->isAlmostPalindrom();

        if ($isPalindrome) {
            $score += 3;
        } elseif ($isAlmostPalindrome) {
            $score += 2;
        }
        return $score;
    }
}
