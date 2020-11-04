<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    /**
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @SecurityAssert\UserPassword(
     *     message = "Ce n'est pas votre mot de passe actuel."
     * )
     */
    private $oldPassword;

    /**
     * @Assert\EqualTo(
     *      propertyPath = "newpassword",
     *      message = "Le mot de passe n'est pas identique."
     * )
     */
    private $confirmPassword;

    /**
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @Assert\Length(
     *      min = 8,
     *      max = 254,
     *      minMessage = "Votre mot de passe doit contenir au moins 8 caractères.",
     *      maxMessage = "Votre mot de passe ne peut pas contenir plus que {{ limit }} caractères !"
     * )
     * @Assert\Regex(
     *     pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)^",
     *     match = true,
     *     message = "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial !"
     * )
     */
    private $newPassword;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
