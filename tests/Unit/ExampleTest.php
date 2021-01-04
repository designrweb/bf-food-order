<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public $allProducts;
    public $calculatedProducts = [];

    public function setUp(): void
    {
        $this->allProducts = [
            [
                'id'     => 3,
                'name'   => 'sahara 3',
                'volume' => 3,
                'square' => 3,
            ],
            [
                'id'     => 5,
                'name'   => 'sahara 5',
                'volume' => 5,
                'square' => 5,
            ],
            [
                'id'     => 9,
                'name'   => 'sahara 9',
                'volume' => 9,
                'square' => 9,
            ],
            [
                'id'     => 16,
                'name'   => 'sahara 16',
                'volume' => 16,
                'square' => 16,
            ],

        ];
    }

    public function calculate($allProducts, $square): void
    {
        $ostatok = 0;

        // 1 variant

        foreach ($allProducts as $product) {
            if ($product['square'] >= $square) {
                $product['calcQuantity'] = 1;
                array_push($this->calculatedProducts, $product);
                break;
            }
//            $mod = fmod($square, $product['square']);
//            if ($mod == 0) {
//                $quantity                = (int)($square / $product['square']);
//                $product['calcQuantity'] = $quantity;
//
//                array_push($calculatedProducts, $product);
//
//                $calculationFinished = true;
//            }
        }

        // 2 variant

//        foreach ($allProducts as $product) {
//            $mod = fmod($square, $product['square']);
//            if ($mod == 0) {
//                $quantity                = (int)($square / $product['square']);
//                $product['calcQuantity'] = $quantity;
//
//                array_push($this->calculatedProducts, $product);
//
//                $calculationFinished = true;
//            }
//        }
//
//        foreach ($allProducts as $product) {
//            if ($square >= $product['square']) {
//                $quantity = (int)($square / $product['square']);
//                $square   = $square - ($quantity * $product['square']);
//
//                $product['calcQuantity'] = $quantity;
//
//                array_push($this->calculatedProducts, $product);
//            }
//        }
//
//        if ($square > 0 && $this->calculatedProducts) {
//            $product['calcQuantity'] = 1;
//            array_push($this->calculatedProducts, $product);
//
////    $this->calculatedProducts[$index]['calcQuantity']++;
//            // do something
//        }

//        return $result;
    }

    /** @test */
    public function it_calculate_quantity_of_products_2()
    {
        $square = 1;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 3,
                'name'         => 'sahara 3',
                'volume'       => 3,
                'square'       => 3,
                'calcQuantity' => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }

    /** @test */
    public function it_calculate_quantity_of_products_3()
    {
        $square = 3;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 3,
                'name'         => 'sahara 3',
                'volume'       => 3,
                'square'       => 3,
                'calcQuantity' => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }

    /** @test */
    public function it_calculate_quantity_of_products_4()
    {
        $square = 4;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 5,
                'name'         => 'sahara 5',
                'volume'       => 5,
                'square'       => 5,
                'calcQuantity' => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }

    /** @test */
    public function it_calculate_quantity_of_products_5()
    {
        $square = 5;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 5,
                'name'         => 'sahara 5',
                'volume'       => 5,
                'square'       => 5,
                'calcQuantity' => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }

    /** @test */
    public function it_calculate_quantity_of_products_6()
    {
        $square = 6;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 3,
                'name'         => 'sahara 3',
                'volume'       => 3,
                'square'       => 3,
                'calcQuantity' => 2
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }


    /** @test */
    public function it_calculate_quantity_of_products_7()
    {
        $square = 7;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 3,
                'name'         => 'sahara 3',
                'volume'       => 3,
                'square'       => 3,
                'calcQuantity' => 2
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }




    /** @test */
    public function it_calculate_quantity_of_products_19()
    {
        $square = 19;

        $this->calculate($this->allProducts, $square);

        $expectedResult = [
            [
                'id'           => 16,
                'name'         => 'sahara 16',
                'volume'       => 16,
                'square'       => 16,
                'calcQuantity' => 1
            ],
            [
                'id'           => 3,
                'name'         => 'sahara 3',
                'volume'       => 3,
                'square'       => 3,
                'calcQuantity' => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($this->calculatedProducts, $expectedResult);
    }




//    function searchForId($id, $array) {
//        foreach ($array as $key => $val) {
//            if ($val['uid'] === $id) {
//                return $key;
//            }
//        }
//        return null;
//    }
//This will work. You should call it like this:
//
//$id = searchForId('100', $userdb);

}
