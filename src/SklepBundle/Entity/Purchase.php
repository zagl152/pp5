<?php

namespace SklepBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Purchase
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Purchase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="purchase_products",
     *      joinColumns={@ORM\JoinColumn(name="purchase_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="products_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    private $products;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Purchase
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Add products
     *
     * @param \SklepBundle\Entity\Product $products
     * @return Purchase
     */
    public function addProduct(\SklepBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \SklepBundle\Entity\Product $products
     */
    public function removeProduct(\SklepBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
