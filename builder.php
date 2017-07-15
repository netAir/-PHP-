<?php
/**
 * Created by PhpStorm.
 * User: netAir
 * Date: 17-7-15
 * Time: 下午3:02
 */
/*
 * 想要创建完整的对象需要将配置传递给各个方法
 */
class Product
{
    protected $type;
    protected $size;
    protected $color;

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
}

/*
 * 创造者
 */
class ProductBuilder
{
    protected $productObject;
    protected $configs;

    public function __construct($configs)
    {
        $this->configs=$configs;
        $this->productObject=new Product();
    }

    public function build()
    {
        $this->productObject->setColor($this->configs['color']);
        $this->productObject->setSize($this->configs['size']);
        $this->productObject->setType($this->configs['type']);
    }

    /**
     * @return Product
     */
    public function getProductObject(): Product
    {
        return $this->productObject;
    }
}