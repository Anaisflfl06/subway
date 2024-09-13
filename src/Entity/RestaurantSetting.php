<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: 'App\Repository\RestaurantSettingRepository')]
#[ORM\Table(name: 'restaurant_setting')]
class RestaurantSetting

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $weekOpeningTime = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $weekClosingTime = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $weekendOpeningTime = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $weekendClosingTime = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $generalName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $serviceType = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $reservationPolicy = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $returnPolicy = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $paymentOptions = [];

    #[ORM\Column(type: 'array', nullable: true)]
    private array $cuisineTypes = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $breakfastHours = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lunchHours = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $dinnerHours = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $specialMenus = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $staffWorkHours = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $staffContactDetails = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $emergencyProcedures = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $staffAccessControls = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $indoorTemperature = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lighting = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $currentPromotions = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $discounts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeekOpeningTime(): ?string
    {
        return $this->weekOpeningTime;
    }

    public function setWeekOpeningTime(?string $weekOpeningTime): self
    {
        $this->weekOpeningTime = $weekOpeningTime;

        return $this;
    }

    public function getWeekClosingTime(): ?string
    {
        return $this->weekClosingTime;
    }

    public function setWeekClosingTime(?string $weekClosingTime): self
    {
        $this->weekClosingTime = $weekClosingTime;

        return $this;
    }

    public function getWeekendOpeningTime(): ?string
    {
        return $this->weekendOpeningTime;
    }

    public function setWeekendOpeningTime(?string $weekendOpeningTime): self
    {
        $this->weekendOpeningTime = $weekendOpeningTime;

        return $this;
    }

    public function getWeekendClosingTime(): ?string
    {
        return $this->weekendClosingTime;
    }

    public function setWeekendClosingTime(?string $weekendClosingTime): self
    {
        $this->weekendClosingTime = $weekendClosingTime;

        return $this;
    }

    public function getGeneralName(): ?string
    {
        return $this->generalName;
    }

    public function setGeneralName(?string $generalName): self
    {
        $this->generalName = $generalName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setServiceType(?string $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getReservationPolicy(): ?string
    {
        return $this->reservationPolicy;
    }

    public function setReservationPolicy(?string $reservationPolicy): self
    {
        $this->reservationPolicy = $reservationPolicy;

        return $this;
    }

    public function getReturnPolicy(): ?string
    {
        return $this->returnPolicy;
    }

    public function setReturnPolicy(?string $returnPolicy): self
    {
        $this->returnPolicy = $returnPolicy;

        return $this;
    }

    public function getPaymentOptions(): ?array
    {
        return $this->paymentOptions;
    }

    public function setPaymentOptions(?array $paymentOptions): self
    {
        $this->paymentOptions = $paymentOptions;

        return $this;
    }

    public function getCuisineTypes(): ?array
    {
        return $this->cuisineTypes;
    }

    public function setCuisineTypes(?array $cuisineTypes): self
    {
        $this->cuisineTypes = $cuisineTypes;

        return $this;
    }

    public function getBreakfastHours(): ?string
    {
        return $this->breakfastHours;
    }

    public function setBreakfastHours(?string $breakfastHours): self
    {
        $this->breakfastHours = $breakfastHours;

        return $this;
    }

    public function getLunchHours(): ?string
    {
        return $this->lunchHours;
    }

    public function setLunchHours(?string $lunchHours): self
    {
        $this->lunchHours = $lunchHours;

        return $this;
    }

    public function getDinnerHours(): ?string
    {
        return $this->dinnerHours;
    }

    public function setDinnerHours(?string $dinnerHours): self
    {
        $this->dinnerHours = $dinnerHours;

        return $this;
    }

    public function getSpecialMenus(): ?string
    {
        return $this->specialMenus;
    }

    public function setSpecialMenus(?string $specialMenus): self
    {
        $this->specialMenus = $specialMenus;

        return $this;
    }

    public function getStaffWorkHours(): ?string
    {
        return $this->staffWorkHours;
    }

    public function setStaffWorkHours(?string $staffWorkHours): self
    {
        $this->staffWorkHours = $staffWorkHours;

        return $this;
    }

    public function getStaffContactDetails(): ?string
    {
        return $this->staffContactDetails;
    }

    public function setStaffContactDetails(?string $staffContactDetails): self
    {
        $this->staffContactDetails = $staffContactDetails;

        return $this;
    }

    public function getEmergencyProcedures(): ?string
    {
        return $this->emergencyProcedures;
    }

    public function setEmergencyProcedures(?string $emergencyProcedures): self
    {
        $this->emergencyProcedures = $emergencyProcedures;

        return $this;
    }

    public function getStaffAccessControls(): ?string
    {
        return $this->staffAccessControls;
    }

    public function setStaffAccessControls(?string $staffAccessControls): self
    {
        $this->staffAccessControls = $staffAccessControls;

        return $this;
    }

    public function getIndoorTemperature(): ?string
    {
        return $this->indoorTemperature;
    }

    public function setIndoorTemperature(?string $indoorTemperature): self
    {
        $this->indoorTemperature = $indoorTemperature;

        return $this;
    }

    public function getLighting(): ?string
    {
        return $this->lighting;
    }

    public function setLighting(?string $lighting): self
    {
        $this->lighting = $lighting;

        return $this;
    }

    public function getCurrentPromotions(): ?string
    {
        return $this->currentPromotions;
    }

    public function setCurrentPromotions(?string $currentPromotions): self
    {
        $this->currentPromotions = $currentPromotions;

        return $this;
    }

    public function getDiscounts(): ?string
    {
        return $this->discounts;
    }

    public function setDiscounts(?string $discounts): self
    {
        $this->discounts = $discounts;

        return $this;
    }
}
