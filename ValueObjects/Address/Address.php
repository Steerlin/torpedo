<?php


namespace Torpedo\ValueObjects\Address;

use JsonSerializable;

class Address implements JsonSerializable
{
    /**
     * @var Street
     */
    private $street;

    /**
     * @var HouseNumber
     */
    private $houseNumber;

    /**
     * @var Bus
     */
    private $bus;

    /**
     * @var PostalCode
     */
    private $postalCode;

    /**
     * @var Municipality
     */
    private $municipality;
    /**
     * @var Country
     */
    private $country;

    /**
     * Address constructor.
     * @param Street|null $street
     * @param HouseNumber|null $number
     * @param Bus|null $bus
     * @param PostalCode|null $postalCode
     * @param Municipality|null $municipality
     * @param Country|null $country
     */
    public function __construct(
        Street $street = null,
        HouseNumber $number = null,
        Bus $bus = null,
        PostalCode $postalCode = null,
        Municipality $municipality = null,
        Country $country = null
    ) {
        $this->street = $street;
        $this->houseNumber = $number;
        $this->bus = $bus;
        $this->postalCode = $postalCode;
        $this->municipality = $municipality;
        $this->country = $country;
    }

    /**
     * @return Street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return HouseNumber
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @return Bus
     */
    public function getBus()
    {
        return $this->bus;
    }

    /**
     * @return PostalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return Municipality
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param Address $other
     * @return bool
     */
    public function equals(Address $other)
    {
        return (
            $this->street->equals($other->street) &&
            $this->houseNumber->equals($other->houseNumber) &&
            $this->bus->equals($other->bus) &&
            $this->postalCode->equals($other->postalCode) &&
            $this->country->equals($other->country) &&
            $this->municipality->equals($other->municipality)
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'street' => $this->street,
            'houseNumber' => $this->houseNumber,
            'bus' => $this->bus,
            'municipality' => $this->municipality,
            'postalCode' => $this->postalCode,
            'country' => $this->country,
        ];
    }

    /**
     * @return null|Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}